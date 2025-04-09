<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body {
            max-width: 1688px;
            margin: 0;
            padding: 20px;
            font-family: Arial, sans-serif;
            word-wrap: break-word;
        }

        a {
            display: block
        }
    </style>
</head>
<body>
@php /** @var \App\Http\DTO\Auth\TwoFactorAuthenticationMailData $contentInfo */ @endphp
<p>{{ $contentInfo->lastName . '　' . $contentInfo->firstName}} 様</p>
<p>いつもS-NETシステムをご利用いただき、誠にありがとうございます。</p>
<p>現在、{{ $contentInfo->lastName . '　' . $contentInfo->firstName}}様のアカウントでログインが試みられています。</p>
<p>セキュリティ保護のため、以下のリンクをクリックし、ログインを認証してください。</p>
<a href="{{ $contentInfo->baseDomain . '?token=' . $contentInfo->token}}">🔗 **[ログインを承認する]**</a>
<p>または、以下のURLをブラウザにコピー＆ペーストしてください：</p>
<p>`{{ $contentInfo->baseDomain . '?token=' . $contentInfo->token}}`</p>
<p>⏳ **このリンクの有効期限は 24 時間です。**</p>
<p>⚠️ **ご注意**</p>
<p>もしこのリクエストをご自身で行っていない場合、第三者が不正にアクセスしようとしている可能性があります。</p>
<p>至急、管理者までご連絡ください。</p>
</body>
</html>
