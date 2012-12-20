dwa
===
**JS vote count "alerts" are heavy-handed; if I had had more time and foresight, I would have created a video object to store
all of the information about each video. This would have made it much easier to keep track of user voting activity. 
Currently, the alerts work OK without page refresh; when the page is refreshed, however, the alerts work as though
the user hasn't voted. The backend works properly, but this would definitely impact the user's experience. 

**User unfollow/follow; The follow feature works on the user_id - not the video ID. This is how I intended the 
application to work, but I am not sure that it makes the most sense from the user's perspective.

**When no one has voted on a video, no number is displayed. 
