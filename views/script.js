
    $('#tweets .btn').click(function(evt){
        // evt.preventDefault();
        // alert($(evt.target).attr('data-user'));
        // alert($(evt.target).attr('data-following'));
        // alert($('#csrf').val());

        evt.preventDefault();
        const userId = $(this).attr('data-user');
        const following = $(this).attr('data-following');
        const btnClass = following ? 'btn-success' : 'btn-primary';
        

        $.ajax({
            method: 'POST',
            url: 'actions.php',
            data: {
                userId,
                following,
                action: 'toggleFollow',
                csrf: $('#csrf').val()
            },
            success: function (data) {
                const ele = $(evt.target)
                const result = JSON.parse(data);
               if(result.success) {
                    following = result.following;
                   if (result.following) { 
    
                       ele.attr('data-following', 1);
                       ele.addClass('btn-success');
                       ele.removeClass('btn-primary');
                       ele.html('UnFollow')
                    
                   } else {
                       ele.attr('data-following', 0);
                       ele.removeClass('btn-success');
                       ele.addClass('btn-primary');
                       ele.html('Follow')
                   }
               }
            
            }
        })
    });

    // post tweet::

    $('#tweetform #btnTweetPost').click(function (evt) {
        evt.preventDefault();
    
        const tweetPost = $('#tweetpost').val();
        if(!tweetPost || tweetPost.length <4){
            alert('Tweet min length is 3!');
            return false;
        }
        const data = $('#tweetform').serialize();
    
        $.ajax({
            method: 'POST',
            url: 'actions.php',
            data:data,
            success: function (data) {
              const tweetData = JSON.parse(data);
               if(!tweetData['success']){
                   alert(tweetData['msg']);
                   return;
               }
               const tweets = document.getElementById('tweets');
               const firstChild = tweets.firstChild;
                const myDiv = document.createElement('div');
                myDiv.innerHTML = tweetData['tweet'];
                tweets.insertBefore(myDiv, firstChild);
                document.getElementById('tweetpost').value ='';  // mio per pulire la post tweet textarea
            }
        })
        
    });

    // filter tweet

    $('#filterTweets #filterTweetsBtn').click(function (evt) {
        evt.preventDefault();
    
        const filterField = $('#filterField').val();
        if(!filterField || filterField.length <4){
            alert('search text min length is 3!');
            return false;
        }
        const data = $('#filterTweets').serialize();
    
        $.ajax({
            method: 'GET',
            url: 'actions.php',
            data:data,
            success: function (data) {
              const tweetData = JSON.parse(data);
               if(!tweetData['success']){
                   alert(tweetData['msg']);
                   return;
               }
               const tweets = document.getElementById('tweets');

               tweets.innerHTML = tweetData['tweets'];
            }
        })
        
    });





//delete tweet

    // $(document).ready(function(){
    //     $('#tweets').on('click', '#deleteTweet', function(evt){
    //         evt.preventDefault();
    //         const tweetDate = $(this).data('datetime'); // Recupera la data del tweet
            
    //         // alert(tweetDate);          E QUI CHE NON FUNZIONA!!!!!!!!!!!!!

    //         if(confirm('Are you sure you want to delete this tweet?')) {
    //             $.ajax({
    //                 method: 'POST',
    //                 url: 'actions.php',
    //                 data: {
    //                     action: 'deleteTweet',
    //                     tweetDate: tweetDate,
    //                     csrf: $('#csrf').val()
    //                 },
    //                 success: function(response) {


    //                 }
    //             });
    //         }
    //     });
    // });
    
