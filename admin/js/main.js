import { initializeEventHandlers } from "./modules/eventHandlers.js";
import './modules/modalManager.js';
import { loadInitialData } from "./modules/api.js";

$(document).ready(() => {
    loadInitialData();
    initializeEventHandlers();
});