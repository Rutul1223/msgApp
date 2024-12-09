<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Msg-App</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Arial', sans-serif;
            background-color: #121212;
            color: #fff;
        }

        .header {
            padding: 20px;
            text-align: center;
            background-color: #1a1a1a;
            position: relative;
        }

        .header h2 {
            font-size: 24px;
            font-weight: bold;
            margin: 0;
        }

        .dropdown {
            position: absolute;
            top: 20px;
            right: 20px;
        }

        .dropdown-button {
            background: #1a1a1a;
            border: 1px solid #333;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
            padding: 10px 20px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            transition: background-color 0.3s ease, border-color 0.3s ease;
        }

        .dropdown-button:hover {
            background-color: #333;
            border-color: #444;
        }

        .dropdown-button svg {
            width: 16px;
            height: 16px;
            margin-left: 8px;
            vertical-align: middle;
            transition: transform 0.3s ease;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #1a1a1a;
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
            z-index: 1;
            top: 100%;
            right: 0;
            border-radius: 8px;
            overflow: hidden;
            border: 1px solid #333;
        }

        .dropdown-content a {
            color: #fff;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
            border-bottom: 1px solid #333;
            transition: background-color 0.3s ease;
        }

        .dropdown-content a:last-child {
            border-bottom: none;
        }

        .dropdown-content a:hover {
            background-color: #333;
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }

        .user-list {
            max-width: 600px;
            margin: 20px auto;
        }

        .user-list a {
            display: flex;
            align-items: center;
            padding: 15px 20px;
            text-decoration: none;
            color: #fff;
            border-bottom: 1px solid #333;
        }

        .user-list img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 15px;
        }

        .user-list div {
            flex: 1;
        }

        .user-list .name {
            font-size: 16px;
            font-weight: bold;
        }

        .user-list .status {
            font-size: 14px;
            color: #a5a5a5;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .user-list .time {
            font-size: 12px;
            color: #a5a5a5;
        }
    </style>
</head>

<body>

    <!-- Header with Dropdown -->
    <div class="header">
        <h2>Chats</h2>
        <div class="dropdown">
            <button class="dropdown-button">
                {{ Auth::user()->name }}
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
            </button>
            <div class="dropdown-content">
                <a href="{{ route('profile.edit') }}">Profile</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();">Log Out</a>
                </form>
            </div>
        </div>
    </div>

    <!-- User List -->
    <div class="user-list">
        @foreach ($users as $user)
        <a href="{{ route('chat', $user->id) }}">
            <img src="https://cdn.pixabay.com/photo/2023/04/11/18/35/pikachu-7917962_640.jpg" alt="{{ $user->name }}">
            <div>
                <div class="name">{{ $user->name }}</div>
                <div class="status">...</div>
            </div>
            <div class="time">1h</div>
        </a>
        @endforeach
    </div>

</body>

</html>
