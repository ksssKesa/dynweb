<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Личный кабинет студента</title>
    <link rel="stylesheet" href="styles.css">
    <script src="https://vk.com/js/api/openapi.js?168" type="text/javascript"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>
<body>
    <div class="container">
        <h2>ВХОД В ЛИЧНЫЙ КАБИНЕТ СТУДЕНТА</h2>
        <br>
        <!-- Форма для ввода логина и пароля -->
        <h2>Вход для Админа</h2>
        <br>
        <form action="login.php" method="post">
            <input type="text" name="login" placeholder="Логин">
            <br>
            <input type="password" name="password" placeholder="Пароль">
            <br>
            <button type="submit" name="button">Войти</button>
        </form>

        <br>

        <!-- Кнопка для входа через ВК -->
        <h2>Вход для студента</h2>
        <button id="VKIDSDKAuthButton" class="VkIdWebSdk__button VkIdWebSdk__button_reset">
            <div class="VkIdWebSdk__button_container">
                <div class="VkIdWebSdk__button_icon">
                    <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M4.54648 4.54648C3 6.09295 3 8.58197 3 13.56V14.44C3 19.418 3 21.907 4.54648 23.4535C6.09295 25 8.58197 25 13.56 25H14.44C19.418 25 21.907 25 23.4535 23.4535C25 21.907 25
                        19.418 25 14.44V13.56C25 8.58197 25 6.09295 23.4535 4.54648C21.907 3 19.418 3 14.44 3H13.56C8.58197 3 6.09295 3 4.54648 4.54648ZM6.79999 10.15C6.91798 15.8728 9.92951 19.31 14.8932 19.31H15.1812V16.05C16.989 16.2332 18.3371 
                        17.5682 18.8875 19.31H21.4939C20.7869 16.7044 18.9535 15.2604 17.8141 14.71C18.9526 14.0293 20.5641 12.3893 20.9436 10.15H18.5722C18.0747 11.971 16.5945 13.6233 15.1803 13.78V10.15H12.7711V16.5C11.305 16.1337 9.39237 14.3538 9.314 10.15H6.79999Z" fill="white"/>
                    </svg>
                </div>
                <div class="VkIdWebSdk__button_text">
                    Войти через VK ID
                </div>
            </div>
        </button>
    </div>

    <!-- Инициализация VK Connect SDK и обработчик события для кнопки -->
    <script type="text/javascript">
        VK.init({
            apiId: 51820718 // мой APP_ID
        });

        document.getElementById('VKIDSDKAuthButton').addEventListener('click', function() {
            VK.Auth.login(function(response) {
                if (response.session) {
                    // Успешная авторизация
                    console.log(response);

                    var url = '/vk_auth.php';
                    var form = $('<form action="' + url + '" method="post">' +
                    '<input type="hidden" name="first_name" value="' + response.session.user.first_name + '" />' +
                    '<input type="hidden" name="last_name" value="' + response.session.user.last_name + '" />' +
                    '<input type="hidden" name="id" value="' + response.session.user.id + '" />' +
                    '</form>');
                    $('body').append(form);
                    form.submit();

                    // Перенаправление на страницу со своими оценками
                    
                } else {
                    // Ошибка авторизации
                    console.error('Ошибка авторизации через VK');
                }
            }, VK.access.EMAIL); // Запрашиваем доступ к email
        });
    </script>

</body>
</html>