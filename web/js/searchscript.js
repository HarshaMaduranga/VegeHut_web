
        function searchVegetables(event) {
            event.preventDefault();
            const keyword = document.getElementById('searchInput').value.trim();
            const results = document.getElementById('searchResults');
            
            if (keyword === "") {
                results.innerHTML = "<p>Please enter a keyword to search.</p>";
                return;
            }

            // Example mock results:
            results.innerHTML = `
                <p>Showing results for: <strong>${keyword}</strong></p>
                <ul>
                    <li>🥕 Fresh Carrots – Kurunegala Region</li>
                    <li>🌽 Sweet Corn – Gampaha Region</li>
                    <li>🍅 Tomatoes – Matale Farms</li>
                </ul>
            `;
        }
    