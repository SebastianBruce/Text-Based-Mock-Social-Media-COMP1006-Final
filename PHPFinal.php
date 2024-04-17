<?php
#Sebastian Bruce - 200561191
#04-11-2024
#Mock social media platform

#Initialize global variables
$users = array("user1", "user2");
$passwords = array("Password1", "Password2");

#Function to create an account
function createAccount() {

    #Call global variable
    global $users, $passwords;

    #Declare variable switch
    $validPassword = false;
    
    #Take user input for account name
    echo "Enter your desired username: ";
    $username = readline();

    #If the entered username already exists in the list then prompt them to login
    if (in_array($username, $users)) {
        echo "Username exists already, rerouting to login.";
        login();
        return;

    #If the username does not exist, prompt user to enter a password
    } else {
        while ($validPassword !== true) {
            
            #Take user input for password
            echo "Set a password (at least 7 characters, with 1 capital and number): ";
            $password = readline();

            #Ensure the password is strong and valid (7 or more characters, 1 or more capitals and numbers)
            if (preg_match("/^(?=.*[A-Z])(?=.*[0-9]).{8,}$/", $password)) {
                echo "Password is valid.\n";
                echo "Account created successfully! Please continue to login.\n";

                #Update necessary variables and array
                $validPassword = true;
                $users[] = $username;
                $passwords[] = $password;

                continue;
            #If password is invalid, continue the loop
            } else {
                echo "Password is invalid. Please try again.\n";
                continue;
            }
        }
    }
}

#Function to log into an existing account
function login() {

    #Call global variable
    global $users, $passwords;

    #Declare variable switch
    $loggedIn = false;
    
    #While not logged in
    while ($loggedIn !== true) {

        #Take user input for username
        echo "Enter your username: ";
        $username = readline();

        #If the username is one that exists
        if (in_array($username, $users)) {

            #Save the index of that username to be tested against in passwords
            $index = array_search($username, $users);
            if ($index !== false && isset($passwords[$index])) {
                $value = $passwords[$index];
            } else {
                continue;
            }

            
            #Take user input for password
            echo "Enter password: ";
            $password = readline();
            
            #If the password does not correspond with the username, prompt until it does
            while ($password !== $value) {
                echo "Incorrect password, try again: ";
                $password = readline();
            }
            
            echo "Now logged in.\n";

            #Flip toggle so the loop ends
            $loggedIn = true;
            continue;
        
        #If the username does not exist
        } else {
            echo "Username does not exist, try again.\n";
            continue;
        }
    }
    return $username;
}

#Function to make a post
function post($username) {

    #Declare variable to be written to
    $post = "";

    #Run until the user quits
    while($post !== "q") {

        #Take user input for post
        echo "Enter your post (or 'q' to quit): ";
        $post = readline();

        if ($post !== "q")
            #If the user doesn't want to quit, echo the post
            echo "{$username}: {$post}\n";
    }
    #If the user wants to quit, quit
    echo "Goodbye.";
    return;
}

#Take user input
echo "Do you have an account? (yes/no): ";
$choice = readline();

#If they enter an invalid option, re prompt until they enter a valid one
while ($choice !== "yes" && $choice !== "no") {
    echo "You must enter yes/no: ";
    $choice = readline();
}

#If they have an account
if ($choice === "yes") {

    #Prompt to login and post
    $username = login();
    post($username);

#If they don't have an account
} elseif ($choice === "no") {

    #Take user input
    echo "Do you want to create an account? (yes/no): ";
    $choice = readline();
    
    #If they want to make an account
    if ($choice === "yes") {

        #Prompt them to create an account, then login, then post
        createAccount();
        $username = login();
        post($username);
    
    #If they don't want to make an account, quit
    } elseif ($choice === "no") {
        echo "You must make an account to use this service. Have a nice day.";
    }
}

?>


