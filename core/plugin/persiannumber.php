<?php
class persiannumber{

  // Navid Mirzaahazadeh
  // 2016/03/17
  // Navidm.ir
  // inavid.ir@gmail.com


    function get($srting)
                {
                    $en_num = array('0','1','2','3','4','5','6','7','8','9');
                    $fa_num = array('۰','۱','۲','۳','۴','۵','۶','۷','۸','۹');
                    return str_replace($en_num, $fa_num, $srting);
}

}
?>
