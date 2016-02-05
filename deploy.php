<?php
require __DIR__ . '/.deployer/symfony.php';

set('shared_dirs', ['var/logs', 'vendor', 'var/data']);
set('writable_dirs', ['var/cache', 'var/logs', 'var/data']);

task('deploy:restart', function() {
    run('/etc/init.d/nginx reload');
    run('/etc/init.d/php5-fpm reload');
});

task('deploy', [
    'deploy:prepare',
    'deploy:release',
    'deploy:update_code',
    'deploy:create_cache_dir',
    'deploy:shared',
    'deploy:writable',
    'deploy:assets',
    'deploy:vendors',
    'deploy:cache:warmup',
    'deploy:symlink',
    'deploy:restart',
    'cleanup',
])->desc('Deploy your project');

set('repository', 'git@github.com:lsv/mybooks.git');

server('prod', 'home.aarhof.eu', 22)
    ->user('root')
    ->forwardAgent()
    ->stage('production')
    ->env('deploy_path', '/var/www/books.aarhof.eu')
;
