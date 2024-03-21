<template>
  <div class="flex justify-center items-center h-screen bg-[#687c8d]">
    <div class="max-w-md w-full p-6 bg-[#e8edf2] rounded-lg shadow-md">
      <h2 class="text-2xl font-semibold">Sign In</h2>
      <hr class="w-full border-[#687c8d] mb-4 mt-4">
      <form @submit.prevent="handleLogin" class="space-y-4">
        <div>
          <label for="email" class="block mb-1">Email</label>
          <input id="email" v-model="state.user.email" placeholder="Enter your email"
            :class="{ 'border-red-500': state.errors && state.errors._data && state.errors._data.errors && state.errors._data.errors.email && v$.user.email.$errors }"
            class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-[#687c8d]">
          <p v-if="state.errors && state.errors._data && state.errors._data.errors && state.errors._data.errors.email"
            class="text-[#ff7765] text-sm tracking-wide font-medium">{{ state.errors._data.errors.email[0] }}</p>
          <p v-else-if="v$.user.email.$errors && v$.user.email.$errors.length > 0"
            class="text-[#ff7765] text-sm tracking-wide font-medium">{{
        v$.user.email.$errors[0].$message }}</p>
        </div>
        <div>
          <label for="password" class="block mb-1">Password</label>
          <input type="password" id="password" v-model="state.user.password" placeholder="Enter your password"
            :class="{ 'border-red-500': state.errors && state.errors._data && state.errors._data.errors && state.errors._data.errors.password }"
            class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-[#687c8d]">
          <p v-if="state.errors && state.errors._data && state.errors._data.errors && state.errors._data.errors.password"
            class="text-[#ff7765] text-sm tracking-wide font-medium">{{ state.errors._data.errors.password[0] }}</p>
        </div>
        <button type="submit" class="w-full px-4 py-2 text-white bg-[#687c8d] rounded hover:bg-[#8495a3] duration-200">
          Login
        </button>
        <div class="flex text-center">
          <nuxt-link to="/register" class="m-auto text-[#99b1c5] text-sm hover:underline">New user? Register
            here.</nuxt-link>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup>
import useVuelidate from '@vuelidate/core';
import { required, email } from '@vuelidate/validators';

const state = reactive({
  errors: null,
  user: {
    email: null,
    password: null,
  }
});

const rules = {
  user: {
    email: { required, email },
    password: { required }
  }
};

const v$ = useVuelidate(rules, state);

async function handleLogin() {
  const params = {
    email: state.user.email,
    password: state.user.password,
  }

  const result = await v$.value.$validate();

  try {
    const response = await $fetch(`http://127.0.0.1:8000/api/auth/login`, {
      method: 'POST',
      body: params
    })

    if (result) {
      if (response.data) {
        localStorage.setItem('_token', response.data.token);
        alert('Signing you in...');
        navigateTo('/viewUsers');
      }
    }
  }
  catch (error) {
    state.errors = error.response;
    console.log('error', error);
  }
}
</script>
