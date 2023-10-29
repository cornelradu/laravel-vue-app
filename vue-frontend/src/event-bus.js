import { ref } from "vue";

const eventBus = ref({});

function emit(event, ...args) {
  if (eventBus.value[event]) {
    eventBus.value[event].forEach((callback) => {
      callback(...args);
    });
  }
}

function on(event, callback) {
  if (!eventBus.value[event]) {
    eventBus.value[event] = [];
  }
  eventBus.value[event].push(callback);
}

export { emit, on };
