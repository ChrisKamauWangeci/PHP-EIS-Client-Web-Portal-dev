class VanillaTableSorter {
    constructor(table) {
        this.table = table;
        this.tbody = table.querySelector("tbody");
        this.headers = Array.from(table.querySelectorAll("th"));
        this.directions = new Array(this.headers.length).fill(true); // ascending by default

        this.headers.forEach((th, i) => {
            th.addEventListener("click", () => this.sortByColumn(i));
        });
    }

    getCellValue(row, index) {
        const cell = row.children[index];
        if (!cell) return "";

        if (cell.dataset.order !== undefined) {
            return cell.dataset.order;
        }

        return cell.innerText.trim();
    }

    extractNumber(str) {
        const match = str.match(/[-+]?[0-9]*\.?[0-9]+/);
        return match ? parseFloat(match[0]) : NaN;
    }

    parseDate(str) {
        str = str.trim();

        // MM/DD/YYYY
        if (/^\d{1,2}\/\d{1,2}\/\d{4}$/.test(str)) {
            const [month, day, year] = str.split("/");
            return new Date(`${year}-${month.padStart(2, "0")}-${day.padStart(2, "0")}`);
        }

        // YYYY-MM-DD
        if (/^\d{4}-\d{2}-\d{2}$/.test(str)) {
            return new Date(str);
        }

        // DD-MM-YYYY
        if (/^\d{2}-\d{2}-\d{4}$/.test(str)) {
            const [day, month, year] = str.split("-");
            return new Date(`${year}-${month.padStart(2, "0")}-${day.padStart(2, "0")}`);
        }

        // Natural date strings (e.g., "14 Jan 2025", "January 14, 2025")
        const parsed = new Date(str);
        if (!isNaN(parsed)) return parsed;

        // Fallback
        return new Date(NaN);
    }

    compare(valA, valB, type, asc) {
        let result = 0;

        switch (type) {
            case "number":
                const numA = this.extractNumber(valA);
                const numB = this.extractNumber(valB);
                if (isNaN(numA) && isNaN(numB)) result = 0;
                else if (isNaN(numA)) result = 1;
                else if (isNaN(numB)) result = -1;
                else result = numA - numB;
                break;

            case "date":
                const dateA = this.parseDate(valA);
                const dateB = this.parseDate(valB);
                result = dateA - dateB;
                break;

            case "string":
            default:
                result = valA.localeCompare(valB, undefined, { sensitivity: "base" });
        }

        return asc ? result : -result;
    }

    sortByColumn(index) {
        const rows = Array.from(this.tbody.querySelectorAll("tr"));
        const direction = this.directions[index];
        const typeAttr = this.headers[index].dataset.type || "string";

        rows.sort((a, b) => this.compare(this.getCellValue(a, index), this.getCellValue(b, index), typeAttr, direction));

        rows.forEach((row) => this.tbody.appendChild(row));
        this.directions[index] = !direction;
        this.updateIndicators(index, !direction);
    }

    updateIndicators(activeIndex, asc) {
        this.headers.forEach((th, i) => {
            th.textContent = th.textContent.replace(/ ↑| ↓/, "");
            if (i === activeIndex) {
                th.textContent += asc ? " ↑" : " ↓";
            }
        });
    }
}

document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll("table.tablesort").forEach((table) => {
        new VanillaTableSorter(table);
    });
});
