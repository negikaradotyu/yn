const mix = require('laravel-mix');

// ... 他の設定 ...

mix.js('resources/js/app.js', 'public/js')
   .sass('resources/sass/app.scss', 'public/css');

// npm run devの前に実行したいタスクを追加します
mix.then(() => {
    // ここに実行したいコマンドを記述します
    // 例えば、npm run devを実行する場合
    require('child_process').spawn('npm', ['run', 'dev']);
});

