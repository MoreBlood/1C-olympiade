<?php
new SEO();

class SEO
{

    private $subDomain_count,
        $subDomains = array(), $html;

    function __construct()
    {
        $this->ReadFile();
        $this->Convert();
    }

    private function ReadFile()
    {

        $data = fopen('4th.txt', "r");
        if ($data === FALSE) return false;

        $this->subDomain_count = trim(fgets($data));
        for ($i = 0; $i < $this->subDomain_count; $i++) {
            $line = explode(" ", trim(fgets($data)));
            $this->subDomains[$line[0]] = $line[1];
        }
        while (!feof($data))
            $this->html .= trim(fgets($data));
    }

    private function Convert()
    {
        $html = $this->html;
        $pattern = '/(?!(src="http))(?!(href="http))((href="\/)|(href=")|(src="\/)|(src="))/';
        $domains_c = count($this->ConvertDomains());

        $callback = function ($matches) use (&$count) {
            $domains = $this->ConvertDomains();
            $count++;
            if (substr($matches[0], -1) == "/") $matches[0] = substr($matches[0], 0, -1);
            return $matches[0] . $domains[$count - 1] . "/";
        };

        $html =
            preg_replace_callback(
                $pattern,
                $callback,
                $html,
                $domains_c,
                $count
            );

        echo $html;
    }

    private function ConvertDomains()
    {
        $domains = array();
        foreach ($this->subDomains as $dm => $value) {
            for ($i = 0; $i < $value; $i++) {
                array_push($domains, $dm);
            }
        }
        return $domains;

    }
}