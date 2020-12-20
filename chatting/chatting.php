<?php
include_once "../util/config.php";
include_once "../login/login_check.php";

$session = $usernickname;
?>
<!DOCTYPE html>
<html>
<head>
	<?php include_once "../fragments/head.php"; ?>
	<script src="./js/jquery.js" type="text/javascript"></script>
	<style type="text/css">
	* {margin:0;padding:0;box-sizing:border-box;font-family:arial,sans-serif;resize:none;}
	html,body {width:100%;height:100%;}	
	</style>
</head>
<body>	
	<!-- Header -->
		<div id="header">
			<?php include_once "../fragments/header.php"; ?>
		</div>
		<div class="wrapper style1 h-50 m-1">
			<div class="contanier h-100">
				<div class="row h-90 m-1">
					<div class="col-2"></div>
					<div class="col border border-dark bg-light h-100 p-4" id="chat_output" style="overflow-y: scroll;"></div>
					<div class="col-2 border border-dark bg-light h-100 p-1 d-flex flex-column" id="chat_userlist">
						<p class="border-bottom border-dark m-1">현재 접속 인원 : <span id="user_num">0</span> 명</p>
						<p id="user_myid" class="m-1 pl-1 lead border-bottom font-weight-bolder"></p>
						<div id="user_list" class="flex-fill" style="overflow-y: scroll;"></div>
					</div>
					<div class="col-2"></div>
				</div>								
				<div class="row m-1">
					<div class="col-2"></div>
					<textarea class="col h-100 p-1" id="chat_input" placeholder="메세지를 입력해주세요!"></textarea>
					<button class="col-1 p-1" id="chat_btn" type="button" style="font-size: 2vw;">보내기</button>
					<div class="col-2"></div>
				</div>
			</div>
		</div>
		

		<!-- Footer -->
		<div id="footer">
			<?php include_once "../fragments/footer.php"; ?>
		</div>

	<script type="text/javascript">
		jQuery(function($){
			// Websocket
			var websocket_server = new WebSocket("wss://salondeahn.me:777/");

			websocket_server.onopen = function(e) { // 사용자 접속 시 서버에 사용자 정보 전달
				websocket_server.send(					
					JSON.stringify({
						'type':'noti_in',
						'user_id':'<?php echo $session; ?>'
					})
				);	
				websocket_server.send(					
					JSON.stringify({
						'type':'user_init',
						'user_id':'<?php echo $session; ?>'
					})
				);
				websocket_server.send(					
					JSON.stringify({
						'type':'user_list_set',
						'user_id':'<?php echo $session; ?>'
					})
				);
				websocket_server.send(					
					JSON.stringify({
						'type':'user_list_in',
						'user_id':'<?php echo $session; ?>'
					})
				);			
			}		
			
			websocket_server.onerror = function(e) {
				// Errorhandling
			}

			websocket_server.onmessage = function(e) {
				var json = JSON.parse(e.data);
				switch(json.type) {
					case 'chat':
						$('#chat_output').append(json.msg);												
						$('#chat_output').scrollTop($('#chat_output')[0].scrollHeight);
						break;
					case 'noti_in':
						$('#chat_output').append(json.msg);
						$('#chat_output').scrollTop($('#chat_output')[0].scrollHeight);
						break;
					case 'noti_out':
						$('#chat_output').append(json.msg);
						$('#chat_output').scrollTop($('#chat_output')[0].scrollHeight);
						break;
					case 'user_num':
						$('#user_num').text(json.msg); // 사용자 접속 시작						
						break;
					case 'user_init':
						$('#user_myid').text(json.msg); // 사용자 접속 시작
						break;
					case 'user_list_set':
						$('#user_list').append(json.msg); // 사용자 접속 시작
						break;
					case 'user_list_in':						
						$('#user_list').append(json.msg); // 새로운 사용자 접속						
						break;
					case 'user_list_out':						
						$(json.msg).remove(); // 사용자 접속 종료
						break;
					case 'double':
						alert('동일한 계정이 채팅중입니다.');
						location.href='/index.php';						
						break;
					// case 'double_msgdel':						
					// 	$(json.msg).remove();
					// 	break;
				}
			}
			// Events
			$('#chat_input').on('keyup',function(e){
				if(e.keyCode==13 && !e.shiftKey) {
					var chat_msg = $(this).val();
					if(chat_msg != "\n") {
						websocket_server.send(
							JSON.stringify({
								'type':'chat',
								'user_id':'<?php echo $session; ?>',
								'chat_msg':chat_msg
							})
						);
					}
					$(this).val('');					
				}
			});			
			$('#chat_btn').click(function() {	
				var chat_msg = $('#chat_input').val();
				if(chat_msg) {					
					websocket_server.send(
						JSON.stringify({
							'type':'chat',
							'user_id':'<?php echo $session; ?>',
							'chat_msg':chat_msg
						})
					);
				}
				$('#chat_input').val('');
			});
		});
		
	</script>

	<!-- Scripts -->
	<script src="/assets/js/jquery.min.js"></script>
			<script src="/assets/js/jquery.dropotron.min.js"></script>
			<script src="/assets/js/jquery.scrolly.min.js"></script>
			<script src="/assets/js/jquery.scrollex.min.js"></script>
			<script src="/assets/js/browser.min.js"></script>
			<script src="/assets/js/breakpoints.min.js"></script>
			<script src="/assets/js/util.js"></script>
			<script src="/assets/js/main.js"></script>
            <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>

        <!-- Bootstrap Stripts-->
			<!-- <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script> -->
			<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
            <script src="/bootstrap/bootstrap.bundle.js"></script>
            <script src="/bootstrap/bootstrap.bundle.min.js"></script>

	
</body>
</html>
