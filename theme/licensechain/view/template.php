<?

// THEME SPECS
$theme_url = $configs["url"]."theme/".$configs["theme"]; // THEME_URL

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <? if(!$meta_extra){ ?>
    <meta name="description" content="<? echo $configs["slogan"]; ?>" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="<? echo $title; ?>" />
    <meta property="og:description" content="<? echo $configs["slogan"]; ?>" />
    <meta property="og:image" content="<? echo $theme_url; ?>/assets/logo.png" />
    <meta property="og:image:height" content="200" />
    <meta property="og:image:width" content="200" />
    <meta property="og:site_name" content="<? echo $configs["title"]; ?>" />
    <meta property="og:url" content="<? echo $configs["url"].'home'; ?>" />
    <meta property="og:locale" content="en_US" />
    <? } else {
      echo $meta_extra;
      }
    ?>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Mono&display=swap" rel="stylesheet">
    <link href="<? echo $theme_url; ?>/assets/css/style.css" rel="stylesheet">
    <link href="<? echo $theme_url; ?>/assets/css/extra.css" rel="stylesheet">
    <title><? echo $title; ?></title>
    <!-- google webmaster -->
    <? echo $configs['meta_google']; ?>
    <!-- bing webmaster -->
    <? echo $configs['meta_bing']; ?>
    <!-- yandex webmaster -->
    <? echo $configs['meta_yandex']; ?>
    <!-- extra head -->
    <? echo $extra_head; ?>
</head>
<body>
  <div id="aa-wp">
    <header id="hd" class="hd">
        <div class="top">
          <div class="cont">
          <button id="menu-btn" class="btn menu-btn lnk"><i class="menu-icon" aria-hidden="true">menu</i></button>
          <figure class="logo"><a href="/"><img src="<? echo $theme_url; ?>/assets/logo.png" alt="License Chain" width="120" height="49"></a></figure>
          <? if ($is_user === 1) { ?>

          <nav>
            <ul class="menu">
              <? echo view("elements/navbar"); ?>
            </ul>
          </nav>
          <div class="mode" style="display: none;">
            <button type="button" class="btn btn-mode lnk npd">
            <i class="fa-sun"><span aria-hidden="true" hidden>dia</span></i>
            <i class="fa-moon"><span aria-hidden="true" hidden>noche</span></i>
            </button>
          </div>
          <div class="user-box aa-drp left">
            <? if ($uinfo["role"] == 4 || $uinfo["role"] == 5) { ?>
              <a href="/profile" class="text-sm md:text-base lg:text-lg px-4 sm:px-6 py-2 rounded hover:text-blue-300">👤 Profile</a>
            <? } ?>
            <a href="/logout" class="text-sm md:text-base lg:text-lg px-4 sm:px-6 py-2 rounded hover:text-blue-300">Logout</a>
          </div>

          <? } ?>
        </div>
      </div>
    </header>

    <?
    //RETURN THE CONTENT
    echo $content;
    ?>

    <footer class="ft">
      <p class="copy cont">©<? echo date("Y"); ?> License Chain - All rights reserved.
        <span>All projects using this service are external to the platform, and provided by the community for the community.</span>
      </p>
    </footer>
  </div>
  <!-- analytics -->
  <? echo base64_decode($configs["meta_analytics"]); ?>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js?v=1.2.4"></script>
  <script src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js?v=1.2.4"></script>
  <script src="<? echo $theme_url; ?>/assets/js/typewatch.js?v=1.2.4"></script>
  <script src="<? echo $theme_url; ?>/assets/js/functions.js?v=8.0"></script>
  <!-- extra_foot -->
  <? echo $extra_foot; ?>
</body>
</html>
