<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AbdurSoft | video Player</title>
    <style>
		body{
			width: 100%;
			height: 100vh;
			overflow-x: hidden;
			margin: 0;
			padding: 0;
			display: flex;
			align-items: center;
			justify-content: center;
		}
		#my_player_box{
			width: 650px;
		}
	</style>
    <script src="http://localhost/video/js/jquery.min.js"></script>
</head>
<body>

    <div id="my_player_box">
		<div id="my_player"></div>
	</div>
	<div id="divBooks"></div>
	<script src="/assets/player/js/master.js"></script>

    <script >



        $(document).ready(function(){
            var player = $("#my_player").absVideo({
                src: "/public/resource/stream.m3u8",
				poster: '',
				encrypt:false,  
				api_key : 'c28zb2llcXVkZWFyb3I3N2xkZWlnNzBmdWFsMDZodDZj',
                background : 'darkblue',
				playback : [0.5,1,1.5,2],
				backward:true,
				forward: true,
				logo : ['https://abdursoft.com/assets/images/logo.png','top',20,'right',25],
				share : true,
				snap : 'no',
				vast : '',
				v360 : false
            });
        });
    </script>
</body>
</html>