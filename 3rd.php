<?php
new CIDR();

class CIDR
{

    private $ips = array();

    function __construct()
    {
        $this->ReadFile();

        foreach ($this->Convert() as $key)
        echo $key, "<br>";
    }
    private function ReadFile()
    {

        $data = fopen('3rd.txt', "r");
        if ($data === FALSE) return false;

        $this->ips = explode(" ", trim(fgets($data)));
    }

    private function Convert()
    {
        $ips = $this->ips;
        $res = array();

        $num = ip2long($ips[1]) - ip2long($ips[0]) + 1;
        $bin = decbin($num);

        $kek = array_reverse(str_split($bin));
        $counter = 0;

        while ($counter < count($kek)) {
            if ($kek[$counter] != 0) {
                $start_ip = isset($range) ? long2ip(ip2long($range[1]) + 1) : $ips[0];
                $range = $this->toIP($start_ip . '/' . (32 - $counter));
                $res[] = $start_ip . '/' . (32 - $counter);
            }
            $counter++;
        }

        return $res;
    }
    private function toIP($cidr)
    {
        $ip_arr = explode('/', $cidr);
        $start = ip2long($ip_arr[0]);
        $nm = $ip_arr[1];
        $num = pow(2, 32 - $nm);
        $end = $start + $num - 1;

        return array($ip_arr[0], long2ip($end));
    }
}