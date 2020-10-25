<template>

    <header class="header flex">
        <h1 class="flex-item">ラーメン×SNS</h1>
        <nav>
            <ul class="flex-item header-list flex">
                <a href="{{ route('home') }}"><li>ホーム</li></a>
                <a href="{{ route('posts.myposts', ['user_id' => Auth::id()]) }}"><li>マイページ</li></a>
                <a href="##"><li>設定</li></a>
                <a href="##"><li>ログアウト</li></a>
            </ul>
        </nav>
    </header>

</template>