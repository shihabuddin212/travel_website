import { onAuthStateChange } from './auth/authHandler';

onAuthStateChange((user) => {
    if (user) {
        // User is signed in
        console.log('User is signed in:', user.uid);
        // Update UI for logged in state
    } else {
        // User is signed out
        console.log('User is signed out');
        // Update UI for logged out state
    }
}); 