<!DOCTYPE html>
<html lang='en'>

<head>
    <meta charset="utf-8">
    <title>Sign up</title>
    <base href="<?= $web_root ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/styles.css" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
</head>

<body>
    <div class="main">
        <header class="t1"><span class="icon"><i class="fa-solid fa-dragon fa-xl" aria-hidden="true"></i></span>Sign Up</header>
        <form id="signupform" action="main/signup" method="post" class="connect2">
            <div class="formtitle">Sign Up</div>
            <div class="contains_input">
                <span class="icon"><i class="fa-regular fa-at fa-sm" aria-hidden="true"></i></span>
                <input id="email" name="email" type="text" placeholder="Email" value="<?= $email ?>" <?php if (array_key_exists('required', $errors) || array_key_exists('validity', $errors)) { ?>class="errorInput" <?php } ?>>
            </div>
            <?php if (array_key_exists('required', $errors)) { ?>
                <p class="errorMessage"><?php echo $errors['required']; ?></p>
            <?php }
            if (array_key_exists('validity', $errors)) { ?>
                <p class="errorMessage"><?php echo $errors['validity']; ?></p>
            <?php } ?>
            <div class="contains_input">
                <span class="icon"><i class="fa-solid fa-user fa-sm" aria-hidden="true"></i></span>
                <input id="full_name" name="full_name" type="text" placeholder="Full Name" value="<?= $full_name ?>" <?php if (array_key_exists('length', $errors) || array_key_exists('name_contains', $errors)) { ?>class="errorInput" <?php } ?>>
            </div>
            <?php if (array_key_exists('length', $errors)) { ?>
                <p class="errorMessage"><?php echo $errors['length']; ?></p>
            <?php }
            if (array_key_exists('name_contains', $errors)) { ?>
                <p class="errorMessage"><?php echo $errors['name_contains']; ?></p>
            <?php } ?>
            <div class="contains_input">
                <span class="icon"><i class="fa-solid fa-credit-card fa-sm" aria-hidden="true"></i></span>
                <input id="iban" name="iban" type="text" placeholder="IBAN - BE12 3456 7890 1234" value="<?= $iban ?>" <?php if (array_key_exists('iban', $errors)) { ?>class="errorInput" <?php } ?>>
            </div>
            <?php if (array_key_exists('iban', $errors)) { ?>
                <p class="errorMessage"><?php echo $errors['iban']; ?></p>
            <?php } ?>
            <div class="contains_input">
                <span class="icon"><i class="fa-solid fa-lock fa-sm" aria-hidden="true"></i></span>
                <input id="password" name="password" type="password" placeholder="Password" value="<?= $password ?>" <?php if (array_key_exists('password_length', $errors) || array_key_exists('password_format', $errors)) { ?>class="errorInput" <?php } ?>>
            </div>
            <?php if (array_key_exists('password_length', $errors)) { ?>
                <p class="errorMessage"><?php echo $errors['password_length']; ?></p>
            <?php }
            if (array_key_exists('password_format', $errors)) { ?>
                <p class="errorMessage"><?php echo $errors['password_format']; ?></p>
            <?php } ?>
            <div class="contains_input">
                <span class="icon"><i class="fa-solid fa-lock fa-sm" aria-hidden="true"></i></span>
                <input id="password_confirm" name="password_confirm" type="password" placeholder="Confirm your password" value="<?= $password_confirm ?>" <?php if (array_key_exists('password_confirm', $errors)) { ?>class="errorInput" <?php } ?>>
            </div>
            <?php if (array_key_exists('password_confirm', $errors)) { ?>
                <p class="errorMessage"><?php echo $errors['password_confirm']; ?></p>
            <?php } ?>
            <input class='login' type="submit" value="Sign Up">
            <a href="index.php" class="button bottom" id='back'>Cancel</a>
        </form>
    </div>
</body>

</html>