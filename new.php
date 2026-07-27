<?php
require_once('functions.php');
setToken(); // (sc19)
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>新規作成</title>
</head>
<body>
  <?php if (!empty($_SESSION['err'])): // (sc19)?> 
    <p><?= $_SESSION['err']; ?></p> 
  <?php endif; ?>
  <form action="store.php" method="post">
    <input type="hidden" name="token" value="<?= $_SESSION['token']; //(sc19)?>"> 
    <input type="text" name="content">
    <input type="submit" value="作成">
  </form>
  <div>
    <a href="index.php">一覧へもどる</a>
  </div>
<?php unsetError(); //(sc19)?> 
</body>
</html>