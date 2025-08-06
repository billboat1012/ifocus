<?php
// test_cron.php
while (true) {
    echo "Running...\n";
    exec('php index.php Cron_generate_pdfs >> ./cron_test.log 2>&1');
    sleep(60); // wait 1 minute
}
?>
