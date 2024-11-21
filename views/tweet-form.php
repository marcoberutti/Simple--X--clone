<form id="tweetform" method="post" action="actions.php">
    <div class="formTweet" style="margin-top:60px;">
        <div class="form-group">
            <input name="action" value="postTweet" type="hidden">
            <input type="hidden" id="tweetcsrf" name="csrf" value="<?=$_SESSION['csrf']?>">
            <textarea required id="tweetpost" name="tweetpost" class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
        </div>
        <div class="form-group">
            <button id="btnTweetPost" class="btn btn-success">POST TWEET</button>
            
        </div>
    </div>
</form>