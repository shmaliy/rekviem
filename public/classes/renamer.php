<?php
class renamer
{
    function renameFile($f)
    {
        $rep[] = array('src' => ' ', 'rep' => '_');
        $rep[] = array('src' => '!', 'rep' => '');
        $rep[] = array('src' => '"', 'rep' => '');
        $rep[] = array('src' => '№', 'rep' => '');
        $rep[] = array('src' => ';', 'rep' => '');
        $rep[] = array('src' => '%', 'rep' => '');
        $rep[] = array('src' => ':', 'rep' => '');
        $rep[] = array('src' => '?', 'rep' => '');
        $rep[] = array('src' => '*', 'rep' => '');
        $rep[] = array('src' => '(', 'rep' => '');
        $rep[] = array('src' => ')', 'rep' => '');
        $rep[] = array('src' => '+', 'rep' => '');
        $rep[] = array('src' => '@', 'rep' => '');
        $rep[] = array('src' => '#', 'rep' => '');
        $rep[] = array('src' => '$', 'rep' => '');
        $rep[] = array('src' => '&', 'rep' => '');
        $rep[] = array('src' => '|', 'rep' => '');
        $rep[] = array('src' => '\\', 'rep' => '');
        $rep[] = array('src' => '/', 'rep' => '');
        $rep[] = array('src' => '~', 'rep' => '');
        $rep[] = array('src' => '\'', 'rep' => '');
        $rep[] = array('src' => '"', 'rep' => '');
        $rep[] = array('src' => '`', 'rep' => '');
        $rep[] = array('src' => '+', 'rep' => '');
        $rep[] = array('src' => '-', 'rep' => '');
        $rep[] = array('src' => '—', 'rep' => '');
        $rep[] = array('src' => '«', 'rep' => '');
        $rep[] = array('src' => '»', 'rep' => '');
        $rep[] = array('src' => 'й', 'rep' => 'i');
        $rep[] = array('src' => 'ц', 'rep' => 'ts');
        $rep[] = array('src' => 'у', 'rep' => 'u');
        $rep[] = array('src' => 'к', 'rep' => 'k');
        $rep[] = array('src' => 'е', 'rep' => 'e');
        $rep[] = array('src' => 'н', 'rep' => 'n');
        $rep[] = array('src' => 'г', 'rep' => 'g');
        $rep[] = array('src' => 'ш', 'rep' => 'sh');
        $rep[] = array('src' => 'щ', 'rep' => 'sch');
        $rep[] = array('src' => 'з', 'rep' => 'z');
        $rep[] = array('src' => 'х', 'rep' => 'h');
        $rep[] = array('src' => 'ъ', 'rep' => '_');
        $rep[] = array('src' => 'ф', 'rep' => 'f');
        $rep[] = array('src' => 'ы', 'rep' => 'y');
        $rep[] = array('src' => 'в', 'rep' => 'v');
        $rep[] = array('src' => 'а', 'rep' => 'a');
        $rep[] = array('src' => 'п', 'rep' => 'p');
        $rep[] = array('src' => 'р', 'rep' => 'r');
        $rep[] = array('src' => 'о', 'rep' => 'o');
        $rep[] = array('src' => 'л', 'rep' => 'l');
        $rep[] = array('src' => 'д', 'rep' => 'd');
        $rep[] = array('src' => 'ж', 'rep' => 'zh');
        $rep[] = array('src' => 'э', 'rep' => 'z');
        $rep[] = array('src' => 'я', 'rep' => 'ya');
        $rep[] = array('src' => 'ч', 'rep' => 'ch');
        $rep[] = array('src' => 'с', 'rep' => 's');
        $rep[] = array('src' => 'м', 'rep' => 'm');
        $rep[] = array('src' => 'и', 'rep' => 'i');
        $rep[] = array('src' => 'т', 'rep' => 't');
        $rep[] = array('src' => 'ь', 'rep' => '_');
        $rep[] = array('src' => 'б', 'rep' => 'b');
        $rep[] = array('src' => 'ю', 'rep' => 'yu');
        $rep[] = array('src' => 'і', 'rep' => 'i');
        $rep[] = array('src' => 'ї', 'rep' => 'yi');
        $rep[] = array('src' => 'є', 'rep' => 'e');
           
        $f = mb_strtolower(iconv('UTF-8', 'windows-1251', $f), 'windows-1251');
        $name = explode('.', $f);
        
        if(count($name) == 1){
            return false;
        }
        
        if(count($name) > 2){
            $ext = $name[count($name)-1];
            unset($name[count($name)-1]);
            $nname[] = implode('', $name);
            $nname[] = $ext;
            $name = $nname;
        }
              
        $prep = str_split($name[0]);
        
        foreach ($prep as &$p){
            $rn = 0;
            if(!preg_match('/^[a-z0-9]+$/', $p)){
                foreach ($rep as $r){
                    if($p == $r['src']){
                        $p = $r['rep'];
                        $rn++;
                    }
                }
                if($rn == 0){
                    $p = '';
                }
            }
        }
        return implode('', $prep) . '.' . $name[1];
    }
}