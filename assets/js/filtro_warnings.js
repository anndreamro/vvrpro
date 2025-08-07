(function(){
    const originalWarn = console.warn;
    console.warn = function (...args) {
    if (args[0] === "Invalid property" && args[1] === "once") return;
    originalWarn.apply(console, args);
};
})
