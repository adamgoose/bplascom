@section('content')
		<div class="row">
			<div class="span12">
				<h2>How To Get In Touch</h2>
				<hr>
			</div>
		</div>

		<div class="row">
			<div class="span12">
				{{Config::get('site.contact.leader')}}
			</div>
		</div>

		<div class="row">
			<div class="span4">
				<h3>Our Location</h3>
				<img src="{{Config::get('site.contact.map')}}" class="img-polaroid img-rounded">
			</div>
			<div class="span4">
				<h3>Contact Info</h3>
				<div class="well">
					<p><strong>Company Address:</strong></p>
					<hr>
					<p>
						{{nl2br(Config::get('site.contact.address'))}}
					</p>
					<hr>
					<p>Don't hesitate to contact us regarding any of your equipment needs. We are open to questions, comments and suggestions.</p>
				</div>
			</div>
			<div class="span4">
				<h3>Email Us</h3>
					{{Form::open(['url' => '/conatct', 'method' => 'post', 'class' => 'form', 'id' => 'contactForm'])}}
						<label for="name">Your name:</label>
						<input class="span4" type="text" id="name" name="name">
						
						<label for="inputEmail">Email:</label>
						<input class="span4" type="text" id="inputEmail" name="email">
						
						<label for="message">Your message:</label>
						<textarea class="span4" rows="4" id="message" name="body"></textarea>
						
						<label class="checkbox">
							<input type="checkbox" name="cc"> Send me a copy
						</label>
						<button type="submit" class="btn btn-primary" id="sendButton">Send Message</button>
					{{Form::close()}}
					<div class="alert alert-success hide" id="successMessage">Your message has been sent!</div>
			</div>
		</div><!-- /.row -->

		<div class="row">
			<div class="span12">
				<h3><span>Privacy Policy</span></h3>
				<div class="alert centered">
					<strong>Our privacy policy</strong>
					Our website does not share personal information of any kind with anyone. We will not sell or rent your name or personal information to any third party. We DO NOT sell, rent or provide outside access to our mailing list or any data we store. Any data that a user stores via our facilities is wholly owned by that user or business. At any time a user or business is free to take their data and leave, or to simply delete their data from our facilities.   
					Our website only collects such personal information that is necessary for you to access and use our services. This personal information includes, but is not limited to, first and last name, physical address, zip code, email address, phone number, social security number, birth date, credit card information, financial information, and other personal information necessary to generate proper legal documents.
				</div>
			</div>
		</div>
	</div><!-- /.container (page container)-->
@stop

@section('scripts')
	<script>
		$(function()
		{
			$("#contactForm").submit(function()
			{
				$("#sendButton").attr('disabled', 'disabled').val('Sending...');
				$.post(
					'/contact',
					$("#contactForm").serialize(),
					function(data) {
						if(data['status'] == 'true') {
							$("#contactForm").slideUp();
							$("#successMessage").slideDown();
						} else {
							alert('There was an unkonwn error while attempting to send your message.');
							$("#sendButton").removeAttr('disabled').val('Send Message');
						}
					},
					"json"
				);
				return false;
			});
		});
	</script>
@stop