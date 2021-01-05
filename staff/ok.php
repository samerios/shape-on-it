<!-- Loading page start after success login and show loading message and go to index page-->

<meta charset="utf-8" />
 <link rel="stylesheet" type="text/css" href="css/w2ui-1.5.rc1.min"/>
<meta http-equiv="refresh" content="3; url='index.php'" />
<meta name="viewport" content="width=device-width, initial-scale=1">

<style>
.loader {
  border: 16px solid #f3f3f3;
  border-radius: 50%;
  border-top: 16px solid blue;
  border-right: 16px solid green;
  border-bottom: 16px solid red;
  border-left: 16px solid pink;
  width: 120px;
  height: 120px;
  -webkit-animation: spin 2s linear infinite;
  animation: spin 2s linear infinite;
}

@-webkit-keyframes spin {
  0% { -webkit-transform: rotate(0deg); }
  100% { -webkit-transform: rotate(360deg); }
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}
</style>

<div align="center">
<h2>Loading...</h2>
<div class="loader"></div>
</div>