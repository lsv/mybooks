<?php
require __DIR__ . '/.deployer/symfony.php';

set('shared_dirs', ['var/logs', 'vendor', 'var/data']);
set('writable_dirs', ['var/cache', 'var/logs', 'var/data', 'var/sessions']);

task('deploy:restart', function() {
    run('service nginx reload');
    run('service php7.0-fpm reload');
});

task('deploy:clear_controllers', function () {

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

server('prod', 'newserver.aarhof.eu', 22)
    ->user('root')
    ->forwardAgent()
    ->stage('production')
    ->env('deploy_path', '/ext/books.aarhof.eu/prod')
;

server('dev', 'newserver.aarhof.eu', 22)
    ->user('root')
    ->forwardAgent()
    ->stage('development')
    ->env('deploy_path', '/ext/books.aarhof.eu/dev')
    ->env('env_vars', 'SYMFONY_ENV=dev')
    ->env('env', 'dev')
    ->env('composer_options', 'install --verbose --prefer-dist --optimize-autoloader --no-progress --no-interaction')
;
