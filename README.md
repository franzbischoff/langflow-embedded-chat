# Langflow Embedded Chat ⛓️

Welcome to the Langflow Embedded Chat repository! 🎉

The Langflow Embedded Chat is a powerful web component that enables seamless communication with the [Langflow ⛓️](https://github.com/logspace-ai/langflow). This widget provides a chat interface, allowing you to integrate Langflow ⛓️ into your web applications effortlessly.

[![MIT License](https://img.shields.io/badge/License-MIT-blue.svg)](https://opensource.org/licenses/MIT)

## What is Langflow?

Langflow is a no-code open-source project that empowers developers to build cutting-edge applications using Language Model technologies. With Langflow, you can leverage the power of LLMs (Large Language Models) to enhance user interactions, generate human-like text, and gain valuable insights from natural language data.

## Features

🌟 Seamless Integration: Easily integrate the Langflow Widget into your website or web application with just a few lines of JavaScript.

🚀 Interactive Chat Interface: Engage your users with a user-friendly chat interface, powered by Langflow's advanced language understanding capabilities.

🎛️ Customizable Styling: Customize the appearance of the chat widget to match your application's design and branding.

🌐 Multilingual Support: Communicate with users in multiple languages, opening up your application to a global audience.

## Installation

### Option 1: CDN Link

Use the Langflow Widget directly from the CDN by including the following script tag in your HTML:

```html
<script src="https://cdn.jsdelivr.net/gh/logspace-ai/langflow-embedded-chat@v1.0.7/dist/build/static/js/bundle.min.js"></script>
```

### Option 2: Local Build

1. Clone this repository to your local machine:

```bash
git clone https://github.com/logspace-ai/langflow-embedded-chat.git
```

2. Navigate to the project directory:

```bash
cd langflow-embedded-chat
```

3. Build the project to generate the bundle:

```bash
npm run build
```

5. After the build process completes, you'll find the bundle in the `dist/build/static/js` folder. You can include this JavaScript file in your HTML:

```html
<script src="path/to/your/langflow-widget.js"></script>
```

## Usage

### on simple HTML
```html
<html lang="en">
<head>
<script src="https://cdn.jsdelivr.net/gh/logspace-ai/langflow-embedded-chat@v1.0.7/dist/build/static/js/bundle.min.js"></script>
</head>
<body>
<langflow-chat
    host_url="langflow url"
    flow_id="your_flow_id"
  ></langflow-chat>
</body>
</html>
```

### on React
 Import the js bundle in the index.html of your react project
```html
<script src="https://cdn.jsdelivr.net/gh/logspace-ai/langflow-embedded-chat@v1.0.7/dist/build/static/js/bundle.min.js"></script>
```
Encapsulate your custom element in a react component
```html
export default function ChatWidget() {
  return (
    <div>
<langflow-chat
    host_url="langflow url"
    flow_id="your_flow_id"></langflow-chat>
    </div>
  );
}
```

## Configuration

Use the widget API to customize your widget:

| Prop                  | Type      | Required |
|-----------------------|-----------|----------|
| api_key               | string    | Yes      |
| flow_id               | string    | Yes      |
| host_url              | string    | Yes      |
| bot_message_style     | json      | No       |
| chat_position         | string    | No       |
| chat_trigger_style    | json      | No       |
| chat_window_style     | json      | No       |
| output_type           | string    | No       |
| input_type            | string    | No       |
| output_component      | string    | No       |
| error_message_style   | json      | No       |
| height                | number    | No       |
| input_container_style | json      | No       |
| input_style           | json      | No       |
| online                | boolean   | No       |
| start_open            | boolean   | No       |
| online_message        | string    | No       |
| placeholder           | string    | No       |
| placeholder_sending   | string    | No       |
| send_button_style     | json      | No       |
| send_icon_style       | json      | No       |
| tweaks                | json      | No       |
| user_message_style    | json      | No       |
| width                 | number    | No       |
| window_title          | string    | No       |
| session_id            | string    | No       |
| additional_headers    | json      | No       |
| initial_messages      | json      | No       |

**api_key:**
- Type: String
- Required: Yes
- Description: X-API-Key header to send to Langflow
- Example: "sk-1234567890abcdef"

**bot_message_style:**
- Type: JSON
- Required: No
- Description: Styling options for formatting bot messages in the chat window.
- Example: `{ "color": "#333", "backgroundColor": "#f0f0f0" }`

**input_type:**
- Type: String
- Required: No
- Description: Specifies the input type for chat messages.
- Example: "text"

**output_type:**
- Type: String
- Required: No
- Description: Specifies the output type for chat messages.
- Example: "text"

**output_component:**
- Type: String
- Required: No
- Description: Specify the output ID for chat messages; this is necessary when multiple outputs are present.
- Example: "output_1"

**chat_position:**
- Type: String
- Required: No
- Description: Determines the position of the chat window (top-left, top-center, top-right, center-left, center-right, bottom-right, bottom-center, bottom-left).
- Example: "bottom-right"

**chat_trigger_style:**
- Type: JSON
- Required: No
- Description: Styling options for the chat trigger.
- Example: `{ "backgroundColor": "#007bff", "color": "#fff" }`

**chat_window_style:**
- Type: JSON
- Required: No
- Description: Styling options for the overall chat window.
- Example: `{ "borderRadius": "8px", "boxShadow": "0 2px 8px rgba(0,0,0,0.1)" }`

**error_message_style:**
- Type: JSON
- Required: No
- Description: Styling options for error messages in the chat window.
- Example: `{ "color": "#ff0000", "fontWeight": "bold" }`

**flow_id:**
- Type: String
- Required: Yes
- Description: Identifier for the flow associated with the component.
- Example: "123e4567-e89b-12d3-a456-426614174000"

**height:**
- Type: Number
- Required: No
- Description: Specifies the height of the chat window in pixels.
- Example: 500

**host_url:**
- Type: String
- Required: Yes
- Description: The URL of the host for communication with the chat component.
- Example: "https://my-langflow-instance.com"

**input_container_style:**
- Type: JSON
- Required: No
- Description: Styling options for the input container where chat messages are typed.
- Example: `{ "padding": "10px", "backgroundColor": "#fafafa" }`

**input_style:**
- Type: JSON
- Required: No
- Description: Styling options for the chat input field.
- Example: `{ "border": "1px solid #ccc", "borderRadius": "4px" }`

**online:**
- Type: Boolean
- Required: No
- Description: Indicates if the chat component is online or offline.
- Example: true

**start_open:**
- Type: Boolean
- Required: No
- Description: Indicates if the chat window should be open by default.
- Example: false

**online_message:**
- Type: String
- Required: No
- Description: Custom message to display when the chat component is online.
- Example: "Chat is online!"

**placeholder:**
- Type: String
- Required: No
- Description: Placeholder text for the chat input field.
- Example: "Type your message..."

**placeholder_sending:**
- Type: String
- Required: No
- Description: Placeholder text to display while a message is being sent.
- Example: "Sending..."

**send_button_style:**
- Type: JSON
- Required: No
- Description: Styling options for the send button in the chat window.
- Example: `{ "backgroundColor": "#28a745", "color": "#fff" }`

**send_icon_style:**
- Type: JSON
- Required: No
- Description: Styling options for the send icon in the chat window.
- Example: `{ "fontSize": "18px" }`

**tweaks:**
- Type: JSON
- Required: No
- Description: Additional custom tweaks for the associated flow.
- Example: `{ "api_key": "sk-xxxx", "temperature": 0.7 }`

**user_message_style:**
- Type: JSON
- Required: No
- Description: Styling options for formatting user messages in the chat window.
- Example: `{ "color": "#222", "backgroundColor": "#e0ffe0" }`

**width:**
- Type: Number
- Required: No
- Description: Specifies the width of the chat window in pixels.
- Example: 350

**window_title:**
- Type: String
- Required: No
- Description: Title for the chat window, displayed in the header or title bar.
- Example: "Support Chat"

**session_id:**
- Type: String
- Required: No
- Description: Custom session id to override the random session id used as default.
- Example: "user-session-001"

**additional_headers:**
- Type: JSON
- Required: No
- Description: Additional headers to be sent to Langflow server
- Example: `{ "X-Custom-Header": "value" }`

**initial_messages:**
- Type: JSON
- Required: No
- Description: Array of initial messages to pre-populate the chat history. Useful for restoring previous conversations from a database.
- Example: `[{"message": "Hello!", "isSend": true}, {"message": "Hi there! How can I help?", "isSend": false}]`
- Message Format: Each message object should have:
  - `message` (string): The message text
  - `isSend` (boolean): `true` for user messages, `false` for bot messages
  - `error` (boolean, optional): `true` to display as error message


## Live example:
Try out or [live example](https://codesandbox.io/s/langflow-embedded-chat-example-dv9zpx) to see how the Langflow Embedded Chat ⛓️ works. 

1. first create a Flow and save it using [Langflow ⛓️](https://github.com/logspace-ai/langflow).
2. Get the hosted URL to use in the live example.
3. If you are using a public host (like [Hugging Face Spaces](https://huggingface.co/spaces/Logspace/Langflow)) use tweaks to keep your API keys safe.

## Restoring Chat History

You can restore previous chat conversations by passing the `initial_messages` prop. This is particularly useful when integrating with Laravel or other backend frameworks where chat history is stored in a database.

**Important:** The `initial_messages` should be set before the widget is rendered or immediately on page load. Once set, the messages will be displayed in the chat window.

### Example with Laravel and jQuery

```html
<html lang="en">
<head>
<script src="https://cdn.jsdelivr.net/gh/logspace-ai/langflow-embedded-chat@v1.0.7/dist/build/static/js/bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
<div id="chat-container"></div>

<script>
// Fetch chat history from your Laravel backend
$.ajax({
    url: '/api/chat-history',
    method: 'GET',
    success: function(history) {
        // Transform your database records to the required format
        var messages = history.map(function(msg) {
            return {
                message: msg.content,
                isSend: msg.is_user_message, // true for user, false for bot
                error: false
            };
        });
        
        // Create the chat widget with initial messages
        var chatWidget = document.createElement('langflow-chat');
        chatWidget.setAttribute('id', 'chat-widget');
        chatWidget.setAttribute('host_url', 'your_langflow_url');
        chatWidget.setAttribute('flow_id', 'your_flow_id');
        chatWidget.setAttribute('api_key', 'your_api_key');
        chatWidget.setAttribute('initial_messages', JSON.stringify(messages));
        
        document.getElementById('chat-container').appendChild(chatWidget);
    }
});
</script>
</body>
</html>
```

### Message Format

Each message in the `initial_messages` array should follow this structure:

```json
{
  "message": "The message text",
  "isSend": true,  // true for user messages, false for bot messages
  "error": false   // optional, true to display as error message
}
```

### Example with Static HTML (Direct Attribute)

For static pages where you know the history beforehand, you can set the attribute directly:

```html
<langflow-chat
    host_url="your_langflow_url"
    flow_id="your_flow_id"
    api_key="your_api_key"
    initial_messages='[{"message":"Previous question","isSend":true},{"message":"Previous answer","isSend":false}]'
></langflow-chat>
```

## License

This project is licensed under the [MIT License](https://opensource.org/licenses/MIT) - see the [LICENSE](https://github.com/logspace-ai/langflow-embedded-chat/tree/main/LICENSE) file for details.
