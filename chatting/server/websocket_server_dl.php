<?php
set_time_limit(0);
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
require dirname(__DIR__) . '/vendor/autoload.php';

class Chat implements MessageComponentInterface {
	protected $runMode = 'P'; // P-운영모드(터미널에 로그 출력 X), D-개발모드(터미널에 로그 출력 O)
	protected $clients;
	protected $users;
	protected $double = 0; // 사용자가 동일한 계정으로 창 2개 띄워서 채팅방 2개 같이 입장한 경우 1로 바뀜

	public function __construct() {
		$this->clients = new \SplObjectStorage;
		$this->conlog("Daily Life Chatting Server Constructed.");
	}

	public function onOpen(ConnectionInterface $conn) { // 사용자가 채팅 접속 시 발생하는 이벤트
		global $users;
		$user_res = $conn->resourceId;
		$this->clients->attach($conn);
		$this->conlog("New connection! ({$conn->resourceId})\n");

		// 사용자 접속 시 채팅창 우측 상단 "전체 접속 인원" 숫자에 현재 접속한 사용자 수 보내는 부분
		$user_num_type = 'user_num';
		$user_num = count($this->clients); // 현재 접속한 사용자 수
		$conn->send(json_encode(array("type"=>$user_num_type,"msg"=>$user_num)));
		$count = 0;
		foreach($this->clients as $client) {
			if($users[$user_res]==$users[$client->resourceId]) {
				// 사용자가 동일한 계정으로 채팅을 창 2개 띄워서 들어올 때 인원수가 늘어나는 것을 방지하기 위해 필요한 과정
				$count++;
			}
		}
		if($count >=2) {
			// $count가 2 이상이라는 말은 한 사용자가 2개 이상의 창을 띄워서 채팅을 들어왔다는 것
			// 따라서 이 경우에는 채팅 참여 인원의 변동을 다른 사용자에게 전달하지 않는다
		} else {
			foreach($this->clients as $client) {
				if($conn!=$client) {
					$client->send(json_encode(array("type"=>$user_num_type,"msg"=>$user_num)));
				}
			}
		}
	}

	public function onClose(ConnectionInterface $conn) { // 사용자가 채팅 종료 시 발생하는 이벤트
		global $users;
		global $double;
		$this->clients->detach($conn);
		$this->conlog("Connection {$conn->resourceId} has disconnected\n");
		$user_res = $conn->resourceId;

		// 사용자 접속 해제 시 전체 사용자 채팅창에 "~님이 퇴장하셨습니다." 메시지 출력하는 부분
		$type = 'noti_out';
		$noti = "<span id='".$user_res."out' style='color:#999'><b>".$users[$user_res]."</b>님이 퇴장하셨습니다.</span><br>";
		$conn->send(json_encode(array("type"=>$type,"msg"=>$noti)));

		if($double == 1) {
			// 사용자가 동일한 계정으로 2개 이상의 창에서 채팅방 들어온 경우 동일 계정으로 접속했다는 안내 팝업 이후 메인화면으로 보냄
			// 다만 이와 같이 if문으로 구분해놓지 않은 경우, 동일 계정으로 2개 이상 들어왔다가 나가면 퇴장했다는 메세지가 출력됨
			// 이 말은, A가 채팅방에 이미 들어온 상태에서 또 다른 창을 열어 동일한 계정으로 채팅방에 들어왔다가 안내 팝업 이후에 나가게 되면
			// 기존에 채팅방에 들어왔던 A가 여전히 있음에도 "A님이 퇴장하셨습니다" 라는 문구가 출력된다는 것임
		} else {
			foreach($this->clients as $client) {
				if($conn!=$client) {
					$client->send(json_encode(array("type"=>$type,"msg"=>$noti)));
				}
			}
			$double = 0;
		}

		// 사용자 접속 해제 시 채팅창 우측 상단 "전체 접속 인원" 숫자에 현재 접속한 사용자 수 보내는 부분
		$user_num_type = 'user_num';
		$user_num = count($this->clients); // 현재 접속한 사용자 목록
		$conn->send(json_encode(array("type"=>$user_num_type,"msg"=>$user_num)));
		foreach($this->clients as $client) {
			if($conn!=$client) {
				$client->send(json_encode(array("type"=>$user_num_type,"msg"=>$user_num)));
			}
		}

		// 사용자 접속 해제 시 채팅창 우측 하단 "전체 접속 인원" 아래에 현재 접속한 사용자 목록에 나간 사용자 닉네임 삭제하는 부분
		$user_list_type = 'user_list_out';
		$user_list_id = '#'.$user_res.'';
		$conn->send(json_encode(array("type"=>$user_list_type,"msg"=>$user_list_id)));
		foreach($this->clients as $client) {
			if($conn!=$client) {
				$client->send(json_encode(array("type"=>$user_list_type,"msg"=>$user_list_id)));
			}
		}
	}

	public function onMessage(ConnectionInterface $from,  $data) {	// 사용자가 채팅에서 메세지 전송 시 발생하는 이벤트
		$from_id = $from->resourceId;
		$data = json_decode($data);
		$type = $data->type;
		$user_id = $data->user_id;
		global $users;
		global $double;
		switch ($type) {
			case 'chat': // 사용자가 채팅에서 메세지 전송 시 발생하는 이벤트
				$numRecv = count($this->clients) - 1; // 현재 채팅방에 있는 사용자 수(보낸 사람 1명 제외)

				$chat_msg = $data->chat_msg;
				$response_from = "<span style='color:#999'><b>".$user_id.":</b> ".$chat_msg."</span><br>"; // 보낸 메세지
				$response_to = "<b>".$user_id."</b>: ".$chat_msg."<br>"; // 받은 메세지
				$this->conlog(sprintf('Connection "%s" sending message "%s" to %s other connection%s'."\n", $from_id, $chat_msg, $numRecv, $numRecv == 1 ? '' : 's'));
				// Output
				$from->send(json_encode(array("type"=>$type,"msg"=>$response_from))); // 사용자 본인이 보낸 메세지이므로 본인에게 보여야 함
				foreach($this->clients as $client)
				{
					if($from!=$client) {
						// 보낸 사람을 제외한 모든 사용자에게 받은 메세지를 보이게 함
						$client->send(json_encode(array("type"=>$type,"msg"=>$response_to)));
					}
				}
				break;
			case 'noti_in': // 사용자 접속 시 전체 사용자 채팅창에 "~님이 입장하셨습니다." 메시지 출력하는 부분
				$users[$from_id] = $user_id;
				$type_double = 'double';
				$count = 0;
				foreach($this->clients as $client) {
					if($users[$from_id]==$users[$client->resourceId]) {
						$count++;
					}
				}
				if($count >=2) { // 사용자가 동일한 계정으로 2개 이상의 창에서 채팅방 들어온 경우 동일 계정 접속했다는 안내 팝업 이후 메인화면으로 보냄
					$from->send(json_encode(array("type"=>$type_double,"msg"=>"")));
					$double = 1;

					break;
				} else {
					$noti = "<span style='color:#999'><b>".$user_id."</b>님이 입장하셨습니다.</span><br>";
					$from->send(json_encode(array("type"=>$type,"msg"=>$noti)));
					foreach($this->clients as $client) {
						if($from!=$client) {
							$client->send(json_encode(array("type"=>$type,"msg"=>$noti)));
						}
					}
					break;
				}

			case 'user_init': // 채팅방 사용자 목록 맨 위에 사용자 본인의 닉네임을 고정시킴
				$user_list_myid = $user_id;
				$count = 0;
				foreach($this->clients as $client) {
					if($users[$from_id]==$users[$client->resourceId]) {
						$count++;
					}
				}
				if($count >=2) {
				} else {
					$from->send(json_encode(array("type"=>$type,"msg"=>$user_list_myid)));
				}
				break;
			case 'user_list_set': // 사용자가 채팅 첫 접속 시 이미 접속 중인 다른 사용자들의 닉네임을 우측 하단 영역 사용자 닉네임 아래에 출력하는 부분
				$count = 0;
				foreach($this->clients as $client) {
					if($users[$from_id]==$users[$client->resourceId]) {
						$count++;
					}
				}
				if($count >=2) {
				} else {
					foreach($this->clients as $client){
						$each_user_res = $client->resourceId;
						$each_user_id = $users[$each_user_res];
						$user_list_id = "<p id=".$each_user_res." class='m-1 pl-1 border-bottom' style='font-size: 1.25rem;'><b>".$each_user_id."</b></p>";
						if($from!=$client) {
							$from->send(json_encode(array("type"=>$type,"msg"=>$user_list_id)));
						}
					}
				}
				break;
			case 'user_list_in': // 다른 사용자 접속 시 채팅창 우측 하단 현재 접속한 사용자 목록에 들어온 사용자 닉네임 추가하는 부분
				$user_list_id = "<p id=".$from_id." class='m-1 pl-1 border-bottom'><b>".$user_id."</b></p>";
				$count = 0;
				foreach($this->clients as $client) {
					if($users[$from_id]==$users[$client->resourceId]) {
						$count++;
					}
				}
				if($count >=2) {
					break;
				} else {
					foreach($this->clients as $client) {
						if($from!=$client) {
							$client->send(json_encode(array("type"=>$type,"msg"=>$user_list_id)));
						}
					}
					break;
				}
		}
	}

	public function onError(ConnectionInterface $conn, \Exception $e) {
		$conn->close();
	}

	 // 서버 구동모드에 따라 로그를 출력한다.
	private function conlog($msg) {
        if ($this->runMode == 'D') {
            echo $msg;
        }
    }
}

$wsPort = 781; //웹소켓 서버 포트 지정
// SSL 인증서를 지정하는 부분
// $loop = React\EventLoop\Factory::create();
// $webSock = new React\Socket\Server('0.0.0.0:'.$wsPort, $loop);
// $webSock = new React\Socket\SecureServer($webSock, $loop, [
//     'local_cert' => '/etc/letsencrypt/live/salondeahn.me/cert.pem', // 인증서 파일 지정
//     'local_pk' => '/etc/letsencrypt/live/salondeahn.me/privkey.pem', // 비공개 키 파일 지정
//     'allow_self_signed' => TRUE,
//     'verify_peer' => FALSE
// ]);

$server = IoServer::factory(
	new HttpServer(new WsServer(new Chat())),
	$wsPort
);
// $server = new IoServer(
// 	new HttpServer(new WsServer(new Chat())),
// 	$webSock, $loop
// );
$server->run();
?>
