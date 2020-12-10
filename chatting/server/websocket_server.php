<?php
//namespace salon_de_ahn;

// include_once "../../util/config.php";

set_time_limit(0);
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
// require_once '../vendor/autoload.php';
require dirname(__DIR__) . '/vendor/autoload.php';

class Chat implements MessageComponentInterface {
	protected $runMode = 'D'; // P-운영모드, D-개발모드
	protected $clients;
	protected $users;
	protected $double = 0;

	public function __construct() {
		$this->clients = new \SplObjectStorage;
		$this->conlog("Constructed.");
	}

	public function onOpen(ConnectionInterface $conn) { // 사용자가 채팅 접속 시 발생하는 이벤트
		global $users;
		$user_res = $conn->resourceId;
		$this->clients->attach($conn);		
		// $this->users[$conn->resourceId] = $conn;
		$this->conlog("New connection! ({$conn->resourceId})\n");						
		// $user_id = $conn->resourceId;

		// 사용자 접속 시 전체 사용자 채팅창에 "~님이 입장하셨습니다." 메시지 출력하는 부분
		// $type = 'noti';
		// $noti = "<span style='color:#999'><b>".$user_id."</b>님이 입장하셨습니다.</span><br>";
		// $conn->send(json_encode(array("type"=>$type,"msg"=>$noti)));
		// foreach($this->clients as $client) {
		// 	if($conn!=$client) {
		// 		$client->send(json_encode(array("type"=>$type,"msg"=>$noti)));
		// 	}
		// }
		// 사용자 접속 시 채팅창 우측 상단 "전체 접속 인원" 숫자에 현재 접속한 사용자 수 보내는 부분
		$user_num_type = 'user_num';
		$user_num = count($this->clients); // 현재 접속한 사용자 수
		$conn->send(json_encode(array("type"=>$user_num_type,"msg"=>$user_num)));
		$count = 0;
		foreach($this->clients as $client) {			
			if($users[$user_res]==$users[$client->resourceId]) {						
				$count++;						
			}
		}
		if($count >=2) {
			
		} else {
			foreach($this->clients as $client) {
				if($conn!=$client) {
					$client->send(json_encode(array("type"=>$user_num_type,"msg"=>$user_num)));
				}
			}
		}
		

		// 사용자 접속 시 채팅창 우측 하단 "전체 접속 인원" 아래에 현재 접속한 사용자 목록에 들어간 사용자 닉네임 추가하는 부분
		// $user_list_type = 'user_list_init';
		// $user_list_myid = "<p id=".$user_id." class='m-1 pl-1 lead border-bottom'><b>".$user_id."</b></p>";
		// $user_list_myid = $user_id;
		// $user_list_id = "<p id=".$user_id." class='m-1 border-bottom'><b>".$user_id."</b></p>";
		// $user_list = print_r($this->clients); // 현재 접속한 사용자 목록		
		// $conn->send(json_encode(array("type"=>$user_list_type,"msg"=>$user_list_myid))); // 채팅방 사용자 목록 맨 위에 사용자 본인의 닉네임을 고정시킴
		// foreach($this->clients as $client){ // 사용자가 채팅 첫 접속 시 이미 접속 중인 다른 사용자들의 닉네임을 출력하는 부분						
		// 	$user_list_type = 'user_list_plus';
		// 	$each_user_id = $client->resourceId;
		// 	$user_list_id = "<p id=".$each_user_id." class='m-1 pl-1 border-bottom' style='font-size: 1.25rem;'>".$each_user_id."</p>";
		// 	if($user_id!=$each_user_id) {
		// 		$conn->send(json_encode(array("type"=>$user_list_type,"msg"=>$user_list_id)));
		// 	}
		// }		
		// foreach($this->clients as $client) {
		// 	if($conn!=$client) {				
		// 		$client->send(json_encode(array("type"=>$user_list_type,"msg"=>$user_list_id)));
		// 		$this->conlog($user_list_type);
		// 	}
		// }
	}

	public function onClose(ConnectionInterface $conn) { // 사용자가 채팅 종료 시 발생하는 이벤트
		global $users;
		global $double;
		$this->clients->detach($conn);
		// unset($this->users[$conn->resourceId]);
		$this->conlog("Connection {$conn->resourceId} has disconnected\n");
		$user_res = $conn->resourceId;

		// 사용자 접속 해제 시 전체 사용자 채팅창에 "~님이 퇴장하셨습니다." 메시지 출력하는 부분
		$type = 'noti_out';
		$noti = "<span id='".$user_res."out' style='color:#999'><b>".$users[$user_res]."</b>님이 퇴장하셨습니다.</span><br>";
		$conn->send(json_encode(array("type"=>$type,"msg"=>$noti)));
		
		if($double == 1) {
			// $type_double_msgdel = 'double_msgdel';
			// $client->send(json_encode(array("type"=>$type_double,"msg"=>$user_res+'out')));
			// $this->conlog($user_res+'out');
		} else {
			foreach($this->clients as $client) {
				if($conn!=$client) {
					$client->send(json_encode(array("type"=>$type,"msg"=>$noti)));
					$this->conlog("왜 들어오지\n");
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
				// $this->conlog('구분');
				// $this->conlog(print_r($users));
				// $this->conlog('구분');
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
				// $this->conlog('noti_in');				
				$users[$from_id] = $user_id;
				$type_double = 'double';
				// $msg = '"동일한 계정이 채팅중입니다."';
				// $this->conlog(print_r($users[$from_id]));
				// $this->conlog("구분선\n");
				$count = 0;
				foreach($this->clients as $client) {										
					if($users[$from_id]==$users[$client->resourceId]) {						
						$count++;
						// $this->conlog($count);
						// $this->conlog("@\n");
					}					
				}
				if($count >=2) {
					$from->send(json_encode(array("type"=>$type_double,"msg"=>"")));
					$double = 1;
					// $this->conlog("if");
					// 	$this->conlog("@\n");
					break;
				} else {
					// $this->conlog("else");
					// $this->conlog("@\n");
					$noti = "<span style='color:#999'><b>".$user_id."</b>님이 입장하셨습니다.</span><br>";
					$from->send(json_encode(array("type"=>$type,"msg"=>$noti)));
					foreach($this->clients as $client) {
						if($from!=$client) {
							$client->send(json_encode(array("type"=>$type,"msg"=>$noti)));
						}
					}
					break;
				}
				// $this->conlog(print_r($users[$from_id]));
				
			// case 'noti_out': // 사용자 접속 시 전체 사용자 채팅창에 "~님이 입장하셨습니다." 메시지 출력하는 부분
			// 	$this->conlog('noti_out');
			// 	$noti = "<span style='color:#999'><b>".$user_id."</b>님이 퇴장하셨습니다.</span><br>";
			// 	$from->send(json_encode(array("type"=>$type,"msg"=>$noti)));
			// 	foreach($this->clients as $client) {
			// 		if($from!=$client) {
			// 			$client->send(json_encode(array("type"=>$type,"msg"=>$noti)));
			// 		}
			// 	}
			// 	break;
			case 'user_init':
				// $this->conlog('user_list_init');				
				$user_list_myid = $user_id;
				$count = 0;
				foreach($this->clients as $client) {										
					if($users[$from_id]==$users[$client->resourceId]) {						
						$count++;
						// $this->conlog($count);
						// $this->conlog("@\n");
					}					
				}
				if($count >=2) {
				} else {
					$from->send(json_encode(array("type"=>$type,"msg"=>$user_list_myid))); // 채팅방 사용자 목록 맨 위에 사용자 본인의 닉네임을 고정시킴				
				}				
				break;
			case 'user_list_set':
				$count = 0;
				foreach($this->clients as $client) {										
					if($users[$from_id]==$users[$client->resourceId]) {						
						$count++;
						// $this->conlog($count);
						// $this->conlog("@\n");
					}					
				}
				if($count >=2) {
				} else {
					foreach($this->clients as $client){ // 사용자가 채팅 첫 접속 시 이미 접속 중인 다른 사용자들의 닉네임을 출력하는 부분											
						$each_user_res = $client->resourceId;
						$each_user_id = $users[$each_user_res];
						$user_list_id = "<p id=".$each_user_res." class='m-1 pl-1 border-bottom' style='font-size: 1.25rem;'><b>".$each_user_id."</b></p>";
						if($from!=$client) {
							$from->send(json_encode(array("type"=>$type,"msg"=>$user_list_id)));
						}
					}
				}				
				break;
			case 'user_list_in':
				// $this->conlog('user_list_in');		
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
				
			// case 'user_list_out':
			// 	$this->conlog('user_list_out');
			// 	$user_list_id = '#'.$from_id.'';
			// 	$from->send(json_encode(array("type"=>$type,"msg"=>$user_list_id)));
			// 	foreach($this->clients as $client) {
			// 		if($from!=$client) {
			// 			$client->send(json_encode(array("type"=>$type,"msg"=>$user_list_id)));
			// 		}
			// 	}
			// 	break;
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

$wsPort = 777;
// SSL 인증서를 지정하는 부분
$loop = React\EventLoop\Factory::create();
$webSock = new React\Socket\Server('0.0.0.0:'.$wsPort, $loop);
$webSock = new React\Socket\SecureServer($webSock, $loop, [
    'local_cert' => '/etc/letsencrypt/live/salondeahn.me/cert.pem', // 인증서 파일 지정
    'local_pk' => '/etc/letsencrypt/live/salondeahn.me/privkey.pem', // 비공개 키 파일 지정
    'allow_self_signed' => TRUE,
    'verify_peer' => FALSE
]);

$server = new IoServer(
	new HttpServer(new WsServer(new Chat())),
	$webSock, $loop
);
$server->run();
?>
