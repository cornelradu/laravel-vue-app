<template>
  <div class="container">
    <div class="login-form">
      <h2>Login</h2>
      <form @submit.prevent="submitForm">
        <div class="form-group">
          <label for="username">Username:</label>
          <input type="text" id="username" v-model="username" required>
        </div>
        <div class="form-group">
          <label for="password">Password:</label>
          <input type="password" id="password" v-model="password"  required>
        </div>
        <button type="submit">Login</button>
      </form>
    </div>
  </div>
</template>

<script>
import { emit } from '@/event-bus';
import axios from 'axios';

export default {
  data() {
    return {
      apiUrl: process.env.VUE_APP_API_BASE_URL,
      username: 'test@gmail.com',
      password: 'test'
    };
  },
  methods: {
    submitForm() {

      axios.post(`${this.apiUrl}/api/login`, {
        email: this.username,
        password: this.password,
      })
      .then(response => {
        // Handle the successful response here
        console.log('Logged in successfully:', response.data);
        localStorage.setItem("jwtToken", response.data.token);
        emit('logged_in')
        this.$router.push({ path: '/' });
      })
      .catch(error => {
        // Handle errors here, such as displaying an error message to the user
        console.error('Error logging in:', error);
      });
    }
  }
};
</script>

<style>


.container {
  text-align: center;
  width: 100%;
  height: 90vh;
  display: flex;
  align-items: center;
  justify-content: center;
}

.login-form {
  background-color: #ffffff;
  padding: 20px;
  border-radius: 8px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
  width: 300px;
  height: 360px;
  margin-top: -50px;
}

.form-group {
  margin-bottom: 20px;
  text-align: left;
}

label {
  display: block;
  font-weight: bold;
  margin-bottom: 5px;
}

input[type="text"],
input[type="password"] {
  width: 100%;
  padding: 8px;
  border: 1px solid #ccc;
  border-radius: 4px;
  font-size: 16px;
}

button {
  background-color: #4caf50;
  color: white;
  border: none;
  padding: 10px 20px;
  border-radius: 4px;
  cursor: pointer;
  font-size: 16px;
  transition: background-color 0.3s;
}

button:hover {
  background-color: #45a049;
}
</style>
