<?php
# getBouncingEmails.php
# Thanks to Antii-Jussi.

error_reporting(E_ALL);
ini_set('display_errors', 1);
echo "Get Bouncing Emails Tool" . PHP_EOL;

# List of subjects to be filtered.
$subjectMatch = [
    'Undelivered Mail Returned to Sender',
    'Undeliverable',
    'Ei voitu toimittaa',
    'Delivery Status Notification (Failure)',
    'Kan ikke leveres',
    'Olevererbart',
    'Kézbesíthetetlen',
    'Onbestelbaar',
    'Unzustellbar',
    'No se ha podido entregar',
    'Error en la entrega',
    'Failure Notice'
];

# Pay attention to these statuses only
$statusMatch = [
    '5.3.0',
    '5.1.1',
    '5.7.1',
    '5.1.10',
    '5.0.0'
];

# Consider the address only if there are more than x error messages for that address
$countMatch = 1;

$server = "{smtp.example.org:993/imap/ssl}INBOX";
$username = "";
$password = "";

$inbox = imap_open($server, $username, $password) or die('Cannot connect to email: ' . imap_last_error());
$emails = imap_search($inbox,'UNDELETED');

if($emails) {

    $output = '';

    $bouncemailsAll = 'bouncemails-all-' . date("Y-m-d") . '-' . uniqid() . '.csv';
    $header = "Recipient#Action#Status#DiagnosticCode\n";
    file_put_contents($bouncemailsAll, $header, FILE_APPEND | LOCK_EX);

    $bouncemailsByRecipient = 'bouncemails-count-by-recipient-' . date("Y-m-d") . '-' . uniqid() . '.csv';
    $header = "Recipient#Count#Status\n";
    file_put_contents($bouncemailsByRecipient, $header, FILE_APPEND | LOCK_EX);

    rsort($emails);
    foreach($emails as $email_number) {

        $overview = imap_fetch_overview($inbox,$email_number,0);

        if (str_replace($subjectMatch, '', $overview[0]->subject) != $overview[0]->subject){

            $message = imap_fetchbody($inbox,$email_number,2);
            $cleanMessage = strip_tags($message);
            preg_match('/Original-Recipient: (.*)/', $cleanMessage, $matches);

            if ($matches){
                $recipient = trim(trim($matches[1], "rfc822;"));
                preg_match('/Action: (.*)/', $cleanMessage, $matches);
                $action = trim($matches[1]);
                preg_match('/Status: (.*)/', $cleanMessage, $matches);
                $status = trim($matches[1]);
                preg_match('/Diagnostic-Code: (.*)/', $cleanMessage, $matches);
                $diagnosticCode = trim($matches[1]);

                if (in_array($status, $statusMatch)){

                    /*
                    $parsedData = "";
                    $parsedData .= $recipient . PHP_EOL;
                    $parsedData .= $action . PHP_EOL;
                    $parsedData .= $status . PHP_EOL;
                    $parsedData .= $diagnosticCode . PHP_EOL;
                    $output .= $overview[0]->subject . PHP_EOL;
                    $output .= $overview[0]->date . PHP_EOL;
                    $output .= $parsedData . PHP_EOL;
                    */

                    if ($recipient) $matchingRecipients[$status][] = $recipient;

                    $line = $recipient . "#" . $action . "#" . $status . "#" . $diagnosticCode . "\n";
                    file_put_contents($bouncemailsAll, $line, FILE_APPEND | LOCK_EX);
                }
            }
        }
    }

    #echo $output;

    foreach ($matchingRecipients as $statusKey => $status) {
        $recipientCount = array_count_values($status);
        foreach ($recipientCount as $recipient => $count) {
            if ((int)$count > $countMatch){
                $line = $recipient . "#" . $count . "#" . $statusKey . "\n";
                file_put_contents($bouncemailsByRecipient, $line, FILE_APPEND | LOCK_EX);
            }
        }
    }

}

imap_close($inbox);

