<?php
echo "<body style='background-color: c0c0c0;'>"; 
error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING); 
function pokazKontakt() { 

    echo '
		<center>
        <h1 style=color:red>Formularz kontaktowy</h1>
		<form>
			<button formaction="index.php">Wstecz</button>
		</form>
		<form id="contact-form" method="POST">
			<label>E-mail: </label>
			<input type="text" id="email" name="email"><br><br>                          
			<label>Temat: </label>
			<input type="text" id="subject"><br><br>
			<label>Treść wiadomości: </label><br>
			<textarea type="text" id="message" style="height: 400px; width: 700px"></textarea><br><br>
            <input type="submit" value="Wyślij">
		</form>
		</center>
    ';

    if (isset($_POST['email'])){
        wyslijMailKontakt("wojtaz@vp.pl");
    }
}

function  wyslijMailKontakt($odbiorca) { 

    if (empty($_POST['subject']) || empty($_POST['message']) || empty($_POST['email']))
    {
        echo 'Wypełnij maila !!';
    }
    else
    {
        @$mail['subject'] = @$_POST['subject'];
        @$mail['body'] =  @$_POST['message'];
        @$mail['sender'] = @$_POST['email'];
        @$mail['reciptient'] = @$odbiorca;

        @$header = "From: Formularz kontaktowy <". $mail['sender']."\n";
        @$header .= "MIME-Version: 1.0\ncontent-Type: text/plain; charset=utf-8\ncontent-Transfer-Encoding:";
        @$header .= "X-Sender: <". $mail['sender'].">\n";
        @$header .= "X-Mailer: PRapwww mail 1.2\n";
        @$header .= "X-Priority: 3\n";
        @$header .= "Return-Path: <". $mail['sender'].">\n";

    
        ini_set('SMTP', "smtp.gmail.com");
        ini_set('smtp_port', "25");
        ini_set('sendmail_from', "wojtalloo300@gmail.com");

        mail(@$mail['reciptient'], @$mail['subject'], @$mail['body'], @$header);

        echo 'Wiadomość została pomyślnie wysłana !!';
    }
}

echo pokazKontakt();

function  przypomnijHaslo($odbiorca) { 

    $username = 'root';
    $password = 'root';

    $mail['subject'] = "Przypomnienie hasła ...";
    $mail['body'] =  $password;
    $mail['sender'] = @$_POST['nadawca@gmail.com'];
    $mail['reciptient'] = $odbiorca;

    $header = "From: Przypomnienie hasla <". $mail['sender']."\n";
    $header .= "MIME-Version: 1.0\ncontent-Type: text/plain; charset=utf-8\ncontent-Transfer-Encoding:";
    $header .= "X-Sender: <". $mail['sender'].">\n";
    $header .= "X-Mailer: PRAPWWW mail 1.2\n";
    $header .= "X-Priority: 3\n";
    $header .= "Return-Path: <". $mail['sender'].">\n";

    mail(@$mail['reciptient'], @$mail['subject'], @$mail['body'], @$header);
}

echo '<center><br><br>Email do przypomnienia hasla: <input type="text" class="form-control" name="email@wp.pl"></center>';
echo '<center><p><form action="" method="POST"><button name="password">Przypomnij haslo</button></form></p></center>';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['password'])) {
        przypomnijHaslo($_POST['email@wp.pl']);
    }
}
?>
