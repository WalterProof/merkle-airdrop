<?php

return [
    'ViteHelper' => [
        'build' => [
            'outDirectory' => 'dist',
            'manifest' => WWW_ROOT . 'dist/.vite/manifest.json',
        ],
        'development' => [
            'scriptEntries' => [],
            'styleEntries' => [],
        ],
    ],
];