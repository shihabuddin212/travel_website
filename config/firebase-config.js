// Import the functions you need from the SDKs you need
import { initializeApp } from "firebase/app";
import { getAuth } from "firebase/auth";

// Your web app's Firebase configuration
const firebaseConfig = {
    apiKey: "AIzaSyChHLjM98YxkGKae1ciJxQrd-xGDnVuMk0",
    authDomain: "bd-adventures-by-ovisoft.firebaseapp.com",
    projectId: "bd-adventures-by-ovisoft-e5ee0",
    storageBucket: "bd-adventures-by-ovisoft.appspot.com",
    messagingSenderId: "558688844628",
    appId: "1:558688844628:web:158e80c4c18d031fae66c1",
    measurementId: "G-2GQS5YFSYM"
};

// Initialize Firebase
const app = initializeApp(firebaseConfig);
const auth = getAuth(app);

export { auth }; 