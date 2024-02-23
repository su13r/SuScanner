<?php
if (isset($_GET['URL'])) {
    echo  check_script($_GET['URL']);
    exit();
}
function check_script($url){
  $scripts = array($url."/wp-login.php",$url."/user/login",$url."/administrator/",$url."/admincp/",$url."/admin/");
  $res = "";
  for ($x = 0; $x <= 4 ; $x++ ){
  $handle = curl_init();
  curl_setopt($handle, CURLOPT_URL, $scripts[$x]);
  curl_setopt($handle, CURLOPT_RETURNTRANSFER, TRUE);
  curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);
  $response = curl_exec($handle);
  $httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
  if($httpCode == 200) {
     $res =  $scripts[$x];
  }
  curl_close($handle);
  }
  if ($res == $url."/wp-login.php" ){
    $scr = "Wordpress";
  }elseif($res == $url."/user/login"){
    $scr = "Drupal";
  }elseif($res == $url."/administrator/"){
    $scr = "Joomla";
  }elseif($res == $url."/admincp"){
    $scr = "Vb";
  }elseif($res == $url."/admin"){
    $scr = "AdminPanel";
  }else{
    $scr = "Unknown";
  }
  $justdomain = removeProtocol($url);
  $ip = gethostbyname($justdomain);
  return "<td>$url</td><td>$scr</td><td>$res</td></td><td><a href='https://www.bing.com/search?q=ip%3A".$ip."%20+&go=Search&qs=ds&form=QBRE'  target='_BLANK' >$ip</a></td>
  <td><a href='https://who.is/whois/".$justdomain."' target='_BLANK' >$justdomain</a></td></tr>";
}
function removeProtocol($url){
  $remove = array("http://","https://" , "www." ," ","/");
  return str_replace($remove,"",$url);
}
?>
<html>
  <head>
    <title>SuScanner</title>
    <style>
      @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@700&display=swap');
      body {
        background: #202020;
        color: whitesmoke;
        font-family: 'Roboto', sans-serif;
        margin: auto;
      }
      #loading{
        display: none;
        margin:auto;
        text-align:center;
        justify-content:center;
        align-items:center;
      }
      #table{
        margin-left: auto;
        margin-right: auto;
        width: 100%;
      }
      th{
        padding: 5px;
        text-align: left;
        font-weight: 500;
        font-size: 18px;
        color: #fff;
        border-bottom: solid 1px #999;
      }
      td{
        padding: 5px;
        text-align: left;
        vertical-align:middle;
        font-weight: 300;
        font-size: 18px;
        color: #fff;
        border-bottom: solid 1px #999;
      }
      a{
        color: #1976d2   !important;
        text-decoration : none;
      }
      .Main{
        margin:auto;
        padding: 30px;
        text-align:center;
        justify-content:center;
        align-items:center;
      }
      .textarea{
        width: 661px;
        height: 169px;
        background: #1A2335;
        border-radius: 2px;
        border-bottom: none;
        border-top: none;
        border-right: none;
        border-left: solid 3px #2d6ebe;
        color: white;
        margin-bottom: 10px;
        text-decoration: none;
        outline: none;
        font-weight: bold;
        font-size: 16px;
        padding: 10px;
      }
      .btn{
        padding: 10px 20px 10px 20px;
        background-color:#1565c0 ;
        border-radius: 6px;
        border: none;
        color: white;
        font-weight: bold;
        transition : 0.4s;
      }
      .btn:hover{
        opacity: 0.8;
      }
    </style>
  </head>
  <body>
    <div class="Main">
        <h1>SuScanner</h1><a target="_blank" href="https://su13r.com" >by Su13R</a>
        <br /><br />
        <img width="40" height="40" src="https://media.giphy.com/media/s2DZETNlHfQVWxhyry/source.gif" id="loading" />
        <br />
        <div id="act">
          <div class="input-field col s12">
            <textarea id="domains" class="textarea" placeholder="https://su13r.com/" ></textarea>
          </div>
          <button class="btn" type="submit" onclick="Scan()" name="action">Start scan</button>
        <div>
        <br /><br />
        <table id="table">
            <tr>
              <th>ID</th>
              <th>Domain</th>
              <th>CMS</th>
              <th>URL</th>
              <th>IP | Bing</th>
              <th>Whois</th>
            </tr>
        </table>
    </div>
    <script>
      function Scan() {
        var domains = document.getElementById('domains');
        domains = domains.value.split("\n");
        var loading = document.getElementById('loading');
        loading.style.display = "block";
        let ix = 0;
        let i = 1;
        for (let index = 0; index < domains.length; index++) {
          var xhttp = new XMLHttpRequest();
          xhttp.onreadystatechange = function() {
              if (this.readyState == 4 && this.status == 200) {
                  table.innerHTML += "<tr><td>"+i+"</td>"+this.responseText;
                  ix++;
                  i++;
                  if (ix  === domains.length  ) {
                    loading.style.display = "none";
                  }
             }
          };
          xhttp.open("GET", "?URL="+domains[index], true);
          xhttp.send();
        }
      }
    </script>
   </body>
</html>
