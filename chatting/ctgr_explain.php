
<?php
switch ($category){
        case 'it': 
?>            
        <h1 class="fs-1">IT 주제 채팅방</h1>
        <p class="fs-1">IT에 대해서 이야기나누는 공간입니다.</p>
<?php
        break; 
        

        case 'fin': 
?>            
    <h1 class="fs-1">금융 주제 채팅방</h1>
    <p class="fs-1">금융에 대해서 이야기나누는 공간입니다.</p>                       
<?php
        break;
        
        case 'ls': 
?>
    <h1 class="fs-1">언어 학습 주제 채팅방</h1>
    <p class="fs-1">언어 학습에 대해서 이야기나누는 공간입니다.</p>                       
<?php
        break;                                                                            

        case 'dl': 
?>
    <h1 class="fs-1">일상 나눔 채팅방</h1>
    <p class="fs-1">일상에 대해서 이야기나누는 공간입니다.</p>                       
<?php
        break;

        default :
?>
        <h1 class="fs-1">전체 주제 채팅방</h1>
        <p class="fs-1">모든 주제에 대해서 자유롭게 이야기나누는 공간입니다.</p>
<?php
}
?>