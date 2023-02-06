<?php
    include '../assets/varnames.php';

	if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')
	$url = "https://";
	else
	$url = "http://";
	$url.= $_SERVER['HTTP_HOST']."/blog/unsubscribe.php";
?>
<html>
	<body style="margin:0;font-family: 'Roboto', sans-serif;line-height: 26px;">
		
		<table style="background-color:#f8f8f8; font-family: 'Roboto', sans-serif; width:100%;">
			<tr>
				<td>
					<table style="padding: 40px 0 0;padding-bottom: 0; width: 600px;margin:0 auto; margin-bottom:40px; border: none;">
								<tr>
									<td style="border: none;clear: both !important;background-color:#ffffff;display: block !important;Margin: 0 auto !important;max-width: 600px !important;border-radius: 10px;">
										<table style="width: 100%; border: none;border: none;">
											<tr style="-webkit-font-smoothing: antialiased;  height: 100%;  -webkit-text-size-adjust: none;  width: 100% !important;">
												<td style=" float: left; padding: 40px 0px 145px;text-align: center;width:100%;background-image: url(assets/images/backgroundshape.png); background-size: cover;background-position: center;">
													<span style="text-align: center;display:inline-block;">
														<a href="<?= $url?>">
															
														</a>
													</span>
												</td>
											</tr>
										</table>

									<table style=" width: 100%; padding:0 50px 30px;border: none;">
										<tr>
											<td style="font-size:20px; color:#0b2354;font-weight: 600; text-align:left;">
											Hi {member_name},
											</td>
										</tr>
										
										<tr><td style="height:20px;">
										<p style="margin-bottom: 0;font-size: 16px;color: #98a4bf;">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
										</td></tr>
										
										<tr>
											<td style="height:15px;"></td>
										</tr>
										
										<tr>
											<td style="font-size:20px; color:#0b2354;;font-weight: 600; text-align:left;">
											Your Login Details -
											</td>
										</tr>

										<tr>
											<td style="height:5px;"></td>
										</tr>

										<tr>
											<td>
												<p style="margin: 0;font-size: 16px;color: #98a4bf;">Please keep these login details safe as they are your keys to the software and your member area:</p>
											</td>
										</tr>
										
										<tr>
											<td style="height:20px;"></td>
										</tr>

										<tr>
											<td>
												<p style="margin:0;font-size:16px; color:#98a4bf;"><span style="color:#0b2354;font-weight:600;margin-right: 15px;">Email -</span>  {member_email}</p>
											</td>
										</tr>

										<tr>
											<td style="height:10px;"></td>
										</tr>

										<tr>
											<td>
												<p style="margin:0;font-size:16px; color:#98a4bf;"><span style="color:#0b2354;font-weight:600;margin-right: 15px;">Password -</span>  {member_password}</p>
											</td>
										</tr>
								</table>
								
								<table style=" width: 100%; padding:0;border: none;">
									<tr>
										<td style="border-bottom: 1px solid #efefef;"></td>
									</tr>
									<tr>
										<td style="height:34px;"></td>
									</tr>
									<tr>
										<td style="padding:0 50px;">
										<p style="margin: 0;font-size: 16px;color: #98a4bf;">To Your Success,</p>
										<p style="margin: 0;font-size: 16px;color: #98a4bf;">The <span style="margin-right: 15px;color: #0b2354;font-weight: 600;">Admin</span></p>
									<tr>
										<td style="height:32px;"></td>
									</tr>
								</table>
								
								<table style=" border: none; width: 100%; padding:11px 20px 12px;  background:#11a1fd;">
									<tr>
										<td style="font-size:14px; color:#ffffff; text-align:center;">Copyright 2022 © SplashDash All Rights Reserved.</td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</body>
</html>

<html>
	<body style="margin:0;font-family: 'Roboto', sans-serif;line-height: 26px;">
		
		<table style="background-color:#f8f8f8; font-family: 'Roboto', sans-serif; width:100%;">
			<tr>
				<td>
					<table style="padding: 40px 0 0;padding-bottom: 0; width: 600px;margin:0 auto; margin-bottom:40px; border: none;">
								<tr>
									<td style="border: none;clear: both !important;background-color:#ffffff;display: block !important;Margin: 0 auto !important;max-width: 600px !important;border-radius: 10px;">
										<table style="width: 100%; border: none;border: none;">
											<tr style="-webkit-font-smoothing: antialiased;  height: 100%;  -webkit-text-size-adjust: none;  width: 100% !important;">
												<td style=" float: left; padding: 40px 0px 145px;text-align: center;width:100%;background-image: url(assets/images/backgroundshape.png); background-size: cover;background-position: center;">
													<span style="text-align: center;display:inline-block;">
														<a href="<?= $url?>" style="text-decoration:none; color:white; font-size:34px; font-weight:bold; font-style:inherit;">
															<?= $globalname ?> Blog
														</a>
													</span>
												</td>
											</tr>
										</table>

									<table style=" width: 100%; padding:0 50px 30px;border: none;">
										<tr>
											<td style="font-size:20px; color:#0b2354;font-weight: 600; text-align:left;">
											Hi {member_name},
											</td>
										</tr>
										
										<tr><td style="height:20px;">
										<p style="margin-bottom: 0;font-size: 16px;color: #98a4bf;">Bellow is our weekly news letters</p>
										</td></tr>
										<tr><td style="height:15px;"></td></tr>
										


										<tr>
											<td style="font-size:20px; color:#0b2354;;font-weight: 500; text-align:left;">
											Post Title
											</td>
										</tr>
										<tr><td style="height:5px;"></td></tr>
										<tr>
											<td>
												<!-- <img style="float:left;" src="<?= $url?>assets/img/logo/alogo-white.png"/> -->
												<img style="float:left; width:40%; margin-right:3px;" src="https://bluntechnology.com/blog/assets/img/logo/logo-dark.png"/>
												<p style="margin: 0;font-size: 16px;color: #98a4bf;">From 
													Data Science, Machine Learning, Deep Learning, and Artificial intelligence are really hot at this moment and offering a lucrative career to programmers with high pay and exciting work. It's a great opportunity for programmers who are willing to learn these new skills and upgrade themselves and want to solve some of the most interesting real-world problems...
												</p>
											</td>
										</tr>
										<tr><td style="height:20px;"></td></tr>



										<tr>
											<td style="font-size:20px; color:#0b2354;;font-weight: 500; text-align:left;">
											Post Title
											</td>
										</tr>
										<tr><td style="height:5px;"></td></tr>
										<tr>
											<td>
												<!-- <img style="float:left;" src="<?= $url?>assets/img/logo/alogo-white.png"/> -->
												<img style="float:left; width:40%;" src="https://bluntechnology.com/blog/assets/img/logo/logo-dark.png"/>
												<p style=" margin-left:10px; margin: 0;font-size: 16px;color: #98a4bf;">From 
													Data Science, Machine Learning, Deep Learning, and Artificial intelligence are really hot at this moment and offering a lucrative career to programmers with high pay and exciting work. It's a great opportunity for programmers who are willing to learn these new skills and upgrade themselves and want to solve some of the most interesting real-world problems...
												</p>
											</td>
										</tr>
										<tr><td style="height:10px;"></td></tr>
								</table>
								
								<table style=" width: 100%; padding:0;border: none;">
									<tr>
										<td style="border-bottom: 1px solid #efefef;"></td>
									</tr>
									<tr>
										<td style="height:34px;"></td>
									</tr>
									<tr>
										<td style="padding:0 50px;">
										<p style="margin: 0;font-size: 16px;color: #98a4bf;">From <span style="margin-right: 15px;color: #0b2354;font-weight: 600;"> <?= $globalname ?> Admin</span></p>
									<tr>
										<td style="height:32px;"></td>
									</tr>
								</table>
								
								<table style=" border: none; width: 100%; padding:11px 20px 12px;  background:#11a1fd;">
									<tr>
										<td style="font-size:14px; color:#ffffff; text-align:center;">Copyright 2022 ©  <?= $globalname ?> All Rights Reserved.</td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</body>
</html>