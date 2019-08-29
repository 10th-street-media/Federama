<!DOCTYPE html>
<html>
<title>Federama 2019 Theme Test</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="themes/federama-2019-blue/style.css">
<body>

<div class="w3-card-4">
<div class="w3-container w3-theme w3-card">
  <h1>Federama</h1>
</div>

<div class="w3-container w3-text-theme">
<h2>w3-text-theme</h2></div>

<ul class="w3-ul w3-border-top">
  <li class="w3-theme-l5">
  <a class="w3-button w3-xlarge w3-circle w3-theme-action"
  style="position:fixed;top:48px;right:24px;">+</a>
  <p>w3-theme-l5 (w3-theme-light)</p>
  </li>
  <li class="w3-theme-l4">
    <p>w3-theme-l4</p>
  </li>
  <li class="w3-theme-l3">
    <p>w3-theme-l3</p>
  </li>
  <li class="w3-theme-l2">
    <p>w3-theme-l2</p>
  </li>
  <li class="w3-theme-l1">
    <p>w3-theme-l1</p>
  </li>
  <li class="w3-theme">
    <p>w3-theme</p>
  </li>
  <li class="w3-theme-d1">
    <p>w3-theme-d1</p>
  </li>
  <li class="w3-theme-d2">
    <p>w3-theme-d2</p>
  </li>
  <li class="w3-theme-d3">
    <p>w3-theme-d3</p>
  </li>
  <li class="w3-theme-d4">
    <p>w3-theme-d4</p>
  </li>
  <li class="w3-theme-d5">
    <p>w3-theme-d5 (w3-theme-dark)</p>
  </li>
</ul>
</div>

</body>
</html>

<?php
$config = array(
    "digest_alg" => "sha512",
    "private_key_bits" => 4096,
    "private_key_type" => OPENSSL_KEYTYPE_RSA,
);

// Create the private and public key
$res = openssl_pkey_new($config);

// Extract the private key from $res to $privKey
openssl_pkey_export($res, $privKey);

// Extract the public key from $res to $pubKey
$pubKey = openssl_pkey_get_details($res);
$pubKey = $pubKey["key"];

$data = 'If you can see this, your server has openssl';

// Encrypt the data to $encrypted using the public key
openssl_public_encrypt($data, $encrypted, $pubKey);

// Decrypt the data using the private key and store the results in $decrypted
openssl_private_decrypt($encrypted, $decrypted, $privKey);

echo $decrypted."<br>\n<br>\n";
echo $privKey."<br>\n<br>\n";
echo $pubKey."<br>\n<br>\n";
?>
