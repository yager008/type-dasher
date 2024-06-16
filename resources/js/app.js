import './bootstrap';
import Alpine from 'alpinejs';

import {createChart} from "./chart.js";
import {typeTextInputFieldUpdated} from "./typeTextInputFieldUpdated.js";
import {onSubmitInputTextBoxButtonClicked} from "./onSubmitInputTextBoxButtonClicked.js";
import {startTimer} from "./startTimer.js";
import {closeDialog} from "./textTyped.js";
// import {renderHeatMap, createSimpleHeatMap} from "./renderHeatMap.js";


// Optionally import the CSS


window.typeTextInputFieldUpdated = typeTextInputFieldUpdated;
window.onSubmitInputTextBoxButtonClicked = onSubmitInputTextBoxButtonClicked;
window.createChart = createChart;
window.startTimer = startTimer;
window.closeDialog = closeDialog;

window.Alpine = Alpine;

Alpine.start();
