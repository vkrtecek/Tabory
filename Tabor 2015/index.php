<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js" type="text/javascript"></script>
<script src="../relogin.js" type="text/javascript"></script>
<link href="LB/lightbox.css" rel="stylesheet" />
<title>Tábor Vlčata 2015</title>
<link rel="stylesheet" href="vlcata.css" />
	<link type="text/css" href="menu.css" rel="stylesheet" />
	<script type="text/javascript" src="jquery.js"></script>
</head>
<body id="body">
<?php
if ( !isset($_REQUEST['name']) || !isset($_REQUEST['passwd']) ) {
	?>
  <script>relogin( '<?= $_SERVER['REMOTE_ADDR']; ?>' );</script>
  <?php
  echo '<h1><a href="../">Zřejmě jste se zapomněli přihlásit</a></h1>';
}
else {
	$name = $_REQUEST['name'];
	$passwd = $_REQUEST['passwd'];
?>
    <form method="post" action="../" id="form_back">
    <input type="hidden" name="name" value="<?php echo $name;?>"/>
    <input  type="hidden" name="passwd" value="<?php echo $passwd;?>"/>
    <button type="submit" name="back" id="back"></button>
    </form>
    <?php
    $moznosti = array('Úvodní stránka', 'První setkání - kostra', 'Druhé setkání - Doba a rozpis', 'Třetí setkání - harmonogram', 'Oddílová rada - 21. červen', 'Oddílová rada - 28. červen');
    $dalsi = array('Zakopávání drahokamů', 'Myšlenková mapa', 'Trasa Sekyry se stanovišti');
    $odkazy = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11);
    $prvni_rada_soubory = array('Nový harmonogram', 'Rozpis všech dnů tábora', 'co je potřeba zařídit', 'Kdo nám jede vařit');
    $druha_rada_soubory = array('Jídelníček na celý tábor');
    ?>
      <div class="div_menu" style="width:1000px; margin-left:68vw;">
          <div id="menu_blue" onClick="zobraz()">
              <br />
              M<br />
              E<br />
              N<br />
              U<br />&nbsp;
          </div>
          
          <div id="menu_red">
              <table rules="none" id="table_menu">
                <?php $cnt = 1;
                foreach ( $moznosti as $each)
                {?>
                    <tr><td>
                        <form method="post" action="?o=<?php echo $cnt; ?>">
                        <input type="hidden" name="name" value="<?php echo $name; ?>" />
                        <input type="hidden" name="passwd" value="<?php echo $passwd; ?>" />
                        <button class="menu"><?php echo $each; ?></button>
                        </form>
                    </td></td>
                    <?php
                    if ( $each == $moznosti[4] )
                    {
                        $vnt = 1;
                        foreach ( $prvni_rada_soubory as $rada_1)
                      {?>
                          <tr><td>
                            <form method="post" action="?o=<?php echo $cnt; ?>&pod=<?php echo $vnt; ?>">
                            <input type="hidden" name="name" value="<?php echo $name; ?>" />
                            <input type="hidden" name="passwd" value="<?php echo $passwd; ?>" />
                            <button class="menu_modre"><?php echo $rada_1; ?></button>
                            </form></td><td class="odsadit">•</td></tr>
                        <?php
                        $vnt++;
                      }
                    }
                    else if ( $each == $moznosti[5] )
                    {
                        $vnt = 1;
                        foreach ( $druha_rada_soubory as $rada_2 )
                        {?>
                            <tr><td>
                                <form method="post" action="?o=<?php echo $cnt; ?>&pod=<?php echo $vnt; ?>">
                                <input type="hidden" name="name" value="<?php echo $name; ?>" />
                                <input type="hidden" name="passwd" value="<?php echo $passwd; ?>" />
                                <button class="menu_modre"><?php echo $rada_2; ?></button>
                                </form>
                            </td><td class="odsadit">•</td></tr>
                            <?php
                            $vnt++;
                        }
                    }
                    $cnt++;
                }
                foreach ( $dalsi as $each)
                {?>
                    <tr><td>
                        <form method="post" action="?o=<?php echo $cnt; ?>">
                        <input type="hidden" name="name" value="<?php echo $name; ?>" />
                        <input type="hidden" name="passwd" value="<?php echo $passwd; ?>" />
                        <button class="menu_dalsi"><?php echo $each; ?></button>
                        </form></td></tr>
                    <?php 
                    ++$cnt;
                }?>
            </table>
          </div>
      </div>
      
      <script type="text/javascript">
      var i = 0;
      $("#menu_red").hide();
      
      
      function zobraz()
      {
          $("#menu_red").slideToggle("slow");
      }
      $("#menu_blue").click(function()
      {
          if (i % 2 == 0)
          {
              $("#menu").css("width", '99%');
          }
          else
          {
              $("#menu").css("width", '1%');
          }
          i++;
      });
      $("#moxo-cz").hide();
      </script>
    
    
    
    
    
    <?php
    if (!isset($_REQUEST['o']) && !isset($_REQUEST['radce']) )
    {
        require('uvod.php');
    }
    else if (isset($_REQUEST['o']))
    {
        if (!isset($_REQUEST['pod']))
        {
            if ($_REQUEST['o'] == $odkazy[0])//1. položka MENU
            {
                require('uvod.php');
            }
            if ($_REQUEST['o'] == $odkazy[1])//1. položka MENU
            {
                require('popis_stary.html');
            }
            else if ($_REQUEST['o'] == $odkazy[2])//2. položka MENU
            {
                require('popis_novy.html');
            }
            else if ($_REQUEST['o'] == $odkazy[3])//3. položka MENU
            {
                require('harmonogram_nevyplneny.php');
            }
            else if ($_REQUEST['o'] == $odkazy[4] && !isset($_REQUEST['pod']))//4. položka MENU
            {
                require('najit.php');
                
            }
            else if ($_REQUEST['o'] == $odkazy[5] && !isset($_REQUEST['pod']))//5 položka MENU
            {
                require('rada2.php');
            }
            elseif ($_REQUEST['o'] == $odkazy[6])
            {
                require('zakopavani.html');
            }
            elseif ($_REQUEST['o'] == $odkazy[7])
            {
                require('myslenkova_mapa.html');
            }
            elseif ($_REQUEST['o'] == $odkazy[8])
            {
                require('sekyra.html');
            }
        }
        
        
        
        if (isset($_REQUEST['pod']))
        {
            if ($_REQUEST['o'] == $odkazy[4])
            {
                if ($_REQUEST['pod'] == '1')//4.1 položka MENU
                {
                    require('harmonogram_vyplneny.php');
                }
                else if ($_REQUEST['pod'] == '2')//4.2 položka MENU
                {
                    require('rozpis_dnu.html');
                }
                else if ($_REQUEST['pod'] == '3')//4.3 položka MENU
                {
                    require('co_je_potreba.html');
                }
                else if ($_REQUEST['pod'] == '4')//4.4 položka MENU
                {
                    require('vareni.html');
                }
                else
                {
                    echo '<h1>Stránka nenalezena</h1>';
                }
            }
            else if ($_REQUEST['o'] == $odkazy[5])
            {
                if ($_REQUEST['pod'] == '1')//5.1 položka MENU
                {
                    require('jidelnicek.html');
                }
            }
            else
            {
                echo '<h1>Stránka nenalezena</h1>';
            }
        }
    }
    else if (isset($_REQUEST['radce']))
    {
        echo "ajiahfsgssdgsdg";
        require('najit.php');
        require ('radci.php');
        if (function_exists($_REQUEST['radce']))
        {
            echo '<div id="pismo">';
            $_REQUEST['radce']($_REQUEST['radce']);
            echo '</div>';
        }
        else if ($_REQUEST['radce'] == '') echo '<p><strong class="red">Někoho vyber</strong></p>';
        else echo '<p><strong class="red" id="velkym">'.$_REQUEST['radce'].'</strong> momentálně nemá nic na starosti.</p>';
    }
    ?>
    
    
    
    
    <script type="text/javascript">
    function otevrit(e)
    {
        var option = $('option:selected', 'select').attr('value');
        <?php 
            $umisteni = $_REQUEST['o'];
            if (isset($_REQUEST['pod'])) $umisteni .= '/'.$_REQUEST['pod'];
        ?>
        window.open('soubory/<?php echo $umisteni;?>/' + e + '.' + option);
    };
    </script>
    <script src="LB/lightbox-plus-jquery.min.js" type="text/javascript"></script>
<?php } ?>
</body>
</html>
