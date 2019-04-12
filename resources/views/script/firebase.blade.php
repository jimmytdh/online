<script src="https://www.gstatic.com/firebasejs/5.9.2/firebase.js"></script>
<script>
    // Initialize Firebase
    var config = {
        apiKey: "AIzaSyAnN5kqE2OQlQCRa7ZGdts1RVtRON-6_-Q",
        authDomain: "tdh-chat.firebaseapp.com",
        databaseURL: "https://tdh-chat.firebaseio.com",
        projectId: "tdh-chat",
        storageBucket: "tdh-chat.appspot.com",
        messagingSenderId: "874994982918"
    };
    try {
        firebase.initializeApp(config);
    }catch(err){
        console.log('Redirect to offline page! Create a offline page.');
    }

</script>