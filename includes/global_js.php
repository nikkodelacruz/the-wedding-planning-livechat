<!-- <script src="http://localhost:3000/socket.io/socket.io.js"></script> -->
<script src="https://wedding-planning-chat-app.herokuapp.com/socket.io/socket.io.js"></script>
<script type="text/javascript">
	// var socket = io.connect("http://localhost:3000/");
	var socket = io.connect("https://wedding-planning-chat-app.herokuapp.com/");
</script>

<audio class="sound-notif" src="<?php echo get_field('sound_notification','option'); ?>"></audio>

