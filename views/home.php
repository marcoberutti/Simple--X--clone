<main class="container">
   <h1>TWITTER APP</h1>
   <div class="row">
      <div class="col-md-8" id="tweets">
<!-- logica php per follow/unfollow -->
   <?php require 'views/tweets.php';?>
   </div>
      <div class="col-md-4">
         <form action="actions.php" class="d-flex" style="width: 18rem;" id="filterTweets">
            <input name="action" value="filterTweet" type="hidden">
            <input type="hidden" id="searchTweetcsrf" name="csrf" value="<?=$_SESSION['csrf']?>">

            <input name="search" id="filterField" class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
            <button id="filterTweetsBtn" class="btn btn-outline-success" type="submit">Search</button>
         </form>
         <?php 
         if(isUserLoggedIn()){
            require 'views/tweet-form.php';
         }
            
         ?>
      </div>
   </div>
</main>

