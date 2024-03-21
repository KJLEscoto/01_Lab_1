<template>
  <div class="items-center w-auto h-screen bg-[#687c8d]">
    <div div v-if="isAuthenticated">
      <div class="p-4">
        <div class="justify-between flex mb-5 items-center">
          <p class="text-lg font-semibold text-white tracking-wide">List of Users</p>
          <button class="py-2 px-4 hover:bg-[#ff8d7b] rounded text-white bg-[#ff5e4d] shadow-md" @click="logout">Log
            out</button>
        </div>

        <table class="w-full border-collapse tracking-wide overflow-y-scroll">
          <thead>
            <tr class="bg-[#8ea9bf] text-white tracking-wide">
              <th class="py-2 border border-gray-300">#</th>
              <th class="py-2 px-4 border border-gray-300">Name</th>
              <th class="py-2 px-4 border border-gray-300">Email</th>
            </tr>
          </thead>
          <tbody class="bg-[#e8edf2]">
            <tr v-for="(t, index) in users" :key="t.id" class="border-b">
              <td class="py-2 border border-gray-300 text-center">{{ index + 1 }}</td>
              <td class="py-2 px-4 border border-gray-300">{{ t.name }}</td>
              <td class="py-2 px-4 border border-gray-300">{{ t.email }}</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <div v-else>
      <div class="flex items-center justify-center h-screen cursor-default">
        <div class="text-white tracking-wider text-center">
          <img class="m-auto mb-3 rounded w-auto h-40 shadow" src="assets/img/wolf.avif" alt="Error">
          <p class="text-2xl font-bold mb-1">Oops, Access denied :( </p>
          <p>Please use valid credentials to access this page.</p>
          <button
            class="mt-2 px-6 py-2 bg-[#4b5a67] rounded tracking-wider font-semibold shadow hover:bg-[#596b7a] duration-200"><nuxt-link
              to="/">GO
              TO
              LOGIN</nuxt-link></button>
        </div>
      </div>
    </div>

  </div>
</template>

<script setup>

const { data: users } = await useFetch('http://127.0.0.1:8000/api/getUsers');
const isAuthenticated = ref(false);
const router = useRouter();

onMounted(() => {
  checkAuthentication();
});

function checkAuthentication() {
  isAuthenticated.value = !!localStorage.getItem('_token');
}

function logout() {
  if (confirm("Are you sure you want to log out?")) {
    localStorage.removeItem('_token');
    isAuthenticated.value = false;
    router.push('/');
  }
}

router.beforeEach((to, from, next) => {
  if (from.path === '/dashboard' && isAuthenticated.value) {
    localStorage.removeItem('_token');
  }
  next();
});
</script>
