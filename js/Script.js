var count = 0;
var elementMember;
var elementPlan;
var elementOverview;
var elementRoutine;

function collapseSidebar() {
    if (count == 0) {
        initializeMember();
        var element = document.getElementById("navbarcollapse");
        element.className = element.className.replace("page-container sidebar-collapsed", "page-container");

        toggleClass(elementMember, "has-sub", memcount);
        toggleClass(elementPlan, "has-sub", plancount);
        toggleClass(elementOverview, "has-sub", overviewcount);
        toggleClass(elementRoutine, "has-sub", routinecount);

        count = 1;
    } else if (count == 1) {
        var element = document.getElementById("navbarcollapse");
        element.className = element.className.replace("page-container", "page-container sidebar-collapsed");

        toggleClass(elementMember, "", memcount);
        toggleClass(elementPlan, "", plancount);
        toggleClass(elementOverview, "", overviewcount);
        toggleClass(elementRoutine, "", routinecount);

        count = 0;
    }
}

function initializeMember() {
    elementMember = document.getElementById("hassubopen");
    elementPlan = document.getElementById("planhassubopen");
    elementOverview = document.getElementById("overviewhassubopen");
    elementRoutine = document.getElementById("routinehassubopen");
}

function toggleClass(element, baseClass, count) {
    if (count == 0) {
        element.className = element.className.replace("has-sub opened", baseClass);
    } else if (count == 1) {
        element.className = element.className.replace("has-sub", baseClass + " opened");
    }
}

var memcount = 0;
var plancount = 0;
var overviewcount = 0;
var routinecount = 0;

function memberExpand(passvalue) {
    if (!elementMember) initializeMember(); // Ensure elements are initialized

    // Toggle based on which section is clicked
    if (passvalue === 'memExpand') {
        toggleExpand(elementMember, "memExpand", memcount);
        memcount = toggleOtherSections(memcount, 1);
    } else if (passvalue === 2) {
        toggleExpand(elementPlan, "planExpand", plancount);
        plancount = toggleOtherSections(plancount, 2);
    } else if (passvalue === 3) {
        toggleExpand(elementOverview, "overviewExpand", overviewcount);
        overviewcount = toggleOtherSections(overviewcount, 3);
    } else if (passvalue === 4) {
        toggleExpand(elementRoutine, "routineExpand", routinecount);
        routinecount = toggleOtherSections(routinecount, 4);
    }
}

// Refined toggleExpand function to use 'display' instead of class replacement
function toggleExpand(element, expandId, count) {
    var expandElement = document.getElementById(expandId);
    if (count == 0) {
        element.classList.add("opened");
        expandElement.style.display = "block";  // Show the submenu
    } else {
        element.classList.remove("opened");
        expandElement.style.display = "none";  // Hide the submenu
    }
}

function toggleOtherSections(currentCount, currentValue) {
    if (currentCount == 1) {
        return 0;
    }
    if (currentValue != 1 && memcount == 1) {
        toggleExpand(elementMember, "memExpand", memcount);
        memcount = 0;
    }
    if (currentValue != 2 && plancount == 1) {
        toggleExpand(elementPlan, "planExpand", plancount);
        plancount = 0;
    }
    if (currentValue != 3 && overviewcount == 1) {
        toggleExpand(elementOverview, "overviewExpand", overviewcount);
        overviewcount = 0;
    }
    if (currentValue != 4 && routinecount == 1) {
        toggleExpand(elementRoutine, "routineExpand", routinecount);
        routinecount = 0;
    }
    return 1;
}