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
            background: linear-gradient(to right, #141e30, #243b55);
            color: #fff;
        }

        .header {
            padding: 20px;
            text-align: center;
            background: rgba(26, 26, 26, 0.9);
            position: relative;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.3);
        }

        .header h2 {
            font-size: 24px;
            font-weight: bold;
            margin: 0;
        }

        .dropdown {
            position: absolute;
            top: 50%;
            right: 20px;
            transform: translateY(-50%);
        }

        .dropdown-button {
            background: #222;
            border: 1px solid #444;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
            padding: 10px 20px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            transition: all 0.3s ease;
        }

        .dropdown-button:hover {
            background: #444;
            border-color: #555;
        }

        .dropdown-button svg {
            width: 16px;
            height: 16px;
            margin-left: 8px;
            transition: transform 0.3s ease;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background: #1a1a1a;
            min-width: 160px;
            box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.3);
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
            transition: all 0.3s ease;
        }

        .dropdown-content a:hover {
            background: #444;
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }

        .user-list {
            max-width: 600px;
            margin: 30px auto;
            background: rgba(26, 26, 26, 0.9);
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.3);
            padding: 10px;
        }

        .user {
            display: flex;
            align-items: center;
            padding: 15px 20px;
            text-decoration: none;
            color: #fff;
            border-radius: 10px;
            margin-bottom: 10px;
            transition: transform 0.3s ease, background 0.3s ease;
            background: linear-gradient(to right, #2c3e50, #4c669f);
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.3);
        }

        .user:hover {
            transform: scale(1.05);
            background: linear-gradient(to right, #3a539b, #2b5876);
        }

        .user img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 15px;
            border: 2px solid #fff;
        }

        .user div {
            flex: 1;
        }

        .user .name {
            font-size: 16px;
            font-weight: bold;
        }

        .user .status {
            font-size: 14px;
            color: #d1d1d1;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .user .time {
            font-size: 12px;
            color: #d1d1d1;
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
        @foreach ($users as $index => $user)
        <a href="{{ route('chat', $user->id) }}" class="user">
            <!-- Different User DPs -->
            <img src="https://i.pravatar.cc/50?img={{ $index + 1 }}" alt="{{ $user->name }}">
            <div>
                <div class="name">{{ $user->name }}</div>
                <div class="status">Hey there! I'm using Msg-App.</div>
            </div>
            <div class="time">1h</div>
        </a>
        @endforeach
    </div>

</body>

</html>
