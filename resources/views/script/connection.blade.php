<?php $user = \Illuminate\Support\Facades\Session::get('user'); ?>
<script>
    var dbRef = firebase.database();
    var chatRef = dbRef.ref('chat');
    // since I can connect from multiple devices or browser tabs, we store each connection instance separately
    // any time that connectionsRef's value is null (i.e. has no children) I am offline
    var myConnectionsRef = dbRef.ref("online/{{ $user->id }}/connections");

    // stores the timestamp of my last disconnect (the last time I was seen online)
    var lastOnlineRef = dbRef.ref("online/{{ $user->id }}/lastOnline");

    var connectedRef = dbRef.ref('.info/connected');
    var onlineList = dbRef.ref('online');
    connectedRef.on('value', function(snap) {
        if (snap.val() === true) {
            // We're connected (or reconnected)! Do anything here that should happen only if online (or on reconnect)
            var con = myConnectionsRef.push();

            // When I disconnect, remove this device
            con.onDisconnect().remove();

            // Add this device to my connections list
            // this value could contain info about the device or a timestamp too
            con.set(true);

            // When I disconnect, update the last time I was seen online
            lastOnlineRef.onDisconnect().set(firebase.database.ServerValue.TIMESTAMP);
        }
    });

    onlineList.on('value',function(snap){
        snap.forEach(function(child) {
            if(child.val().connections){
                console.log(child.key+" is online");
                $('.text-status-'+child.key).html('<i class="fa fa-circle text-success"></i> Online');
            }else{
                var timestamp = child.val().lastOnline;
                date = new Date(timestamp);
                console.log(child.key+" last login "+date.getDate()+"-"+(date.getMonth() + 1) +" "+date.getHours()+":"+date.getMinutes());
                var hour = date.getHours();
                var ampm = 'am';
                var month = getMonth(date.getMonth());
                var day = date.getDate();
                var minutes = date.getMinutes();
                if(hour>12){
                    hour -= 12;
                    ampm = 'pm';
                }
                if(hour<10){
                    hour = '0'+hour;
                }
                if(day<10){
                    day = '0'+day;
                }
                if(minutes<10){
                    minutes = '0'+minutes;
                }

                var last_login = month +' '+day+' '+hour+':'+date.getMinutes()+' '+ampm;
                $('.text-status-'+child.key).html('<i class="fa fa-circle text-danger"></i> '+last_login);
            }
        });
    });

    function getMonth(num){
        var months = ['Jan','Feb','Mar','Apr','May'];
        return months[num];
    }

    chatRef.on('child_added',function(snapshot){
        var data = snapshot.val();
        var current_id = "{{ $user->id }}";
        if(current_id == data.receiver_id){
            $("#user-panel-"+data.sender_id).prependTo($("#new-message"));
            $(".img-"+data.sender_id).addClass('new');
        }
    });
</script>