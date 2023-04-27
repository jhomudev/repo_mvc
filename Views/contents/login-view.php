<div class="container_general">
  <div class="bg"></div>
  <div class="section">
    <div class="section__logo">
      <svg id="Capa_1" x="0px" y="0px" width="271px" height="69.333px" viewBox="41.417 23.714 271 69.333" enable-background="new 41.417 23.714 271 69.333" xml:space="preserve" class="logo">
        <g>
          <g>
            <polygon fill="#0A39E4" points="270.887,47.59 280.047,47.59 280.047,75.471 288.473,75.471 288.473,47.59 297.584,47.59  297.584,41.009 270.887,41.009  "></polygon>
            <path fill="#0A39E4" d="M157.647,40.377c-8.514,0-12.192,4.691-13.378,6.708l-0.189,0.319v6.948l0.216,0.338 c1.367,2.128,3.458,4.537,11.026,6.217l3.278,0.722c2.888,0.647,3.846,1.453,4.389,2.238v3.1c-0.835,1.189-2.65,2.42-5.343,2.42 c-3.354,0-4.871-1.721-5.341-2.413v-4.312h-8.226v6.373l0.193,0.325c1.217,2.026,4.955,6.745,13.374,6.745 c8.088,0,11.822-4.229,13.329-6.745l0.194-0.325v-7.701l-0.208-0.33c-1.618-2.627-4.086-4.703-10.869-6.286l-3.291-0.768 c-3.175-0.729-4.029-1.488-4.496-2.155V49.46c0.815-1.186,2.62-2.41,5.341-2.41c2.765,0,4.584,1.269,5.343,2.398v3.918h8.181 v-5.962l-0.191-0.323C169.789,45.066,166.108,40.377,157.647,40.377"></path>
            <polygon fill="#0A39E4" points="227.506,61.807 216.018,41.009 206.977,41.009 206.977,75.471 215.006,75.471 215.006,54.586  226.545,75.471 235.581,75.471 235.581,41.009 227.506,41.009  "></polygon>
            <rect x="303.357" y="41.009" fill="#0A39E4" width="8.371" height="34.462"></rect>
            <polygon fill="#0A39E4" points="184.789,61.079 198.801,61.079 198.801,54.502 184.789,54.502 184.789,47.59 199.831,47.59  199.831,41.009 176.419,41.009 176.419,75.471 200.223,75.471 200.223,68.892 184.789,68.892  "></polygon>
            <path fill="#0A39E4" d="M250.693,41.009l-9.985,29.847l-0.022,4.617h6.904l2.854-8.934l0.082-0.254h10.104l2.933,9.188h7.391V71 L260.895,41.01L250.693,41.009L250.693,41.009z M252.549,60.062l3.088-9.555l3.02,9.555H252.549z"></path>
          </g>
          <polygon fill="#0A39E4" points="113.389,43.451 113.282,43.266 113.174,43.078 71.877,43.078 66.645,52.237 71.877,61.397  88.834,61.397 90.471,64.249 89.18,66.504 68.956,66.504 60.803,52.237 68.956,37.969 110.257,37.969 110.149,37.783  110.042,37.593 105.5,29.643 105.501,29.643 102.201,23.865 62.897,23.865 43.252,58.242 51.704,73.032 51.811,73.217  51.917,73.405 93.21,73.405 98.446,64.247 93.21,55.084 76.239,55.087 74.611,52.237 75.902,49.978 96.133,49.978 104.287,64.247  96.133,78.515 54.837,78.515 54.945,78.702 55.052,78.891 62.897,92.62 102.201,92.62 121.836,58.242  "></polygon>
        </g>
      </svg>
    </div>
    <h1 class="section__welcome">Bienvenido a SINFO</h1>
    <form action="" method="POST" class="form">
      <h2 class="form__title">Ingresa a tu cuenta</h2>
      <div class="form__group">
        <i class="ph-user"></i><input class="form__input" type="email" name="tx_correo" value="<?php echo isset($_POST['tx_correo']) ? $_POST['tx_correo'] : ""; ?>" placeholder="Correo institucional" required />
      </div>
      <div class="form__group">
        <i class="ph-lock"></i><input class="form__input" type="password" name="tx_password" value="<?php echo isset($_POST['tx_password']) ? $_POST['tx_password'] : ""; ?>" placeholder="Password" required />
      </div>
      <input class="form__button" type="submit" value="Ingresar" />
    </form>
    <a class="link__repo" href="<?php echo SERVER_URL; ?>/repository">Ir al repositorio institucional</a>
  </div>
</div>
<?php

require_once "./Controllers/LoginController.php";

$login = new LoginController();

if (isset($_POST['tx_correo']) && isset($_POST['tx_password'])) echo $login->LoginController();
else echo $login->forceLogin();

?>