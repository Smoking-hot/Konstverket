<?php
// Tar emot bokbeställningen och skickar den som e-post via one.com:s PHP mail().
// Kunden får också en bekräftelse på att beställningen tagits emot.

$to    = 'goddag@bhs-konstverket.se';
$from  = 'goddag@bhs-konstverket.se'; // måste vara en adress på den egna domänen
$price = 595;

function back($path) {
    header('Location: ' . $path);
    exit;
}

function clean($key, $max = 200) {
    $v = trim((string)($_POST[$key] ?? ''));
    $v = str_replace(["\r", "\n"], ' ', $v);
    return mb_substr($v, 0, $max);
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') back('bestall/');

// Fälla för spamrobotar: fältet är dolt för människor
if (!empty($_POST['website'])) back('tack/');

$antal      = (int)($_POST['antal'] ?? 0);
$fornamn    = clean('fornamn');
$efternamn  = clean('efternamn');
$email      = clean('email');
$adress     = clean('adress');
$postnummer = clean('postnummer', 20);
$ort        = clean('ort');
$meddelande = mb_substr(trim((string)($_POST['meddelande'] ?? '')), 0, 3000);

if ($antal < 1 || $antal > 50 || $fornamn === '' || $efternamn === '' || $adress === ''
    || $postnummer === '' || $ort === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    back('bestall/?status=error');
}

$namn  = "$fornamn $efternamn";
$summa = $antal * $price;

$body = "Ny beställning från webbplatsen\n\n"
      . "Antal böcker: $antal\n"
      . "Summa: $summa SEK + frakt\n\n"
      . "Namn: $namn\n"
      . "E-post: $email\n"
      . "Adress: $adress\n"
      . "        $postnummer $ort\n\n"
      . "Meddelande:\n" . ($meddelande !== '' ? $meddelande : '–') . "\n";

$headers = "From: BHS Konstverket <$from>\r\n"
         . "Reply-To: $email\r\n"
         . "MIME-Version: 1.0\r\n"
         . "Content-Type: text/plain; charset=UTF-8\r\n";

$subject = '=?UTF-8?B?' . base64_encode("Beställning: $antal st – $namn") . '?=';

if (!mail($to, $subject, $body, $headers)) back('bestall/?status=error');

// Bekräftelse till kunden
$confirm = "Hej $fornamn!\n\n"
         . "Tack för din beställning av Bertil Herlow-Svensson 1929–2012 – En konstnärsmonografi.\n"
         . "Vi återkommer inom kort med konfirmation och information om betalning samt förväntad leveranstid.\n\n"
         . "Din beställning:\n"
         . "Antal: $antal st à $price SEK (frakt tillkommer)\n"
         . "Leveransadress: $adress, $postnummer $ort\n\n"
         . "Vänliga hälsningar\nBHS Konstverket\n$to\n";
$confirmHeaders = "From: BHS Konstverket <$from>\r\n"
                . "MIME-Version: 1.0\r\n"
                . "Content-Type: text/plain; charset=UTF-8\r\n";
mail($email, '=?UTF-8?B?' . base64_encode('Tack för din beställning – BHS Konstverket') . '?=', $confirm, $confirmHeaders);

back('tack/');
