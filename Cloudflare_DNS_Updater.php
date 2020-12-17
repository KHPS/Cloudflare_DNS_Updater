<?php
/**Check current ip against myip.com**/
$myip_com = str_replace(array('{', '}', '"'), '', file_get_contents('https://api.myip.com'));
$ip = explode(':', str_replace(',', ':', $myip_com));


if($ip[1] !== file_get_contents('ip.md')){

    echo shell_exec("curl -X PUT 'https://api.cloudflare.com/client/v4/zones/insert zone/dns_records/insert record ID/' \
    -H 'Authorization: Bearer insert token' \
    -H 'Content-Type: application/json'
    --data '{\"type\":\"A\",\"name\":\"example.com\",\"content\":\"$ip[1]\",\"ttl\":120,\"proxied\":true}' . ");

    sleep(1);

    $get_new_ip = fopen("ip.md", "w");
    fwrite($get_new_ip, $ip[1]);
    fclose($get_new_ip);

    sleep(5);
    /**Script should start again here**/
    shell_exec('php /var/www/Cloudflare_DNS_Updater.php > /dev/null 2>&1 &');
}else{
    echo "No changes to public IP\n";
    sleep(600); /**Raise this value to around 600 (10 minutes) on production system**/
    /**Use shell_exec to run the script again**/
    shell_exec('php /var/www/Cloudflare_DNS_Updater.php > /dev/null 2>&1 &');
}
?>
