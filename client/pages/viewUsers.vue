<template>
  <div class="items-center h-screen bg-[#687c8d]">
    <div class="p-4">
      <div class="justify-between flex mb-5 items-center">
        <p class="text-lg font-semibold text-white tracking-wide">List of Users</p>
        <!-- <button class="py-2 px-4 hover:bg-[#ff8d7b] rounded text-white bg-[#ff5e4d]" @click="logout">Log out</button> -->
      </div>

      <table class="w-full border-collapse tracking-wide">
        <thead>
          <tr class="bg-[#8ea9bf] text-white tracking-wide">
            <th class="py-2 border border-gray-300">#</th>
            <th class="py-2 px-4 border border-gray-300">Name</th>
            <th class="py-2 px-4 border border-gray-300">Email</th>
          </tr>
        </thead>
        <tbody class="bg-[#e8edf2]">
          <tr v-for="(t, index) in data.users" :key="t.id" class="border-b">
            <td class="py-2 border border-gray-300 text-center">{{ index + 1 }}</td>
            <td class="py-2 px-4 border border-gray-300">{{ t.name }}</td>
            <td class="py-2 px-4 border border-gray-300">{{ t.email }}</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

  
<script>
export default {
  async setup() {
    const data = ref(null);

    onMounted(() => {
      checkLogged();
    });

    async function checkLogged() {
      if (!localStorage.getItem('_token')) {
        console.log('no token');
      }
    }
    try {
      const { data } = await useFetch('http://127.0.0.1:8000/api/getUsers/');

      return { data };
    } catch (error) {
      console.error('Error fetching users:', error);
    }
  },
};
</script>