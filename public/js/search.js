// Desktop Search Box Component
function searchBox() {
    return {
        query: '',
        suggestions: [],
        showSuggestions: false,
        isLoading: false,
        searchTimeout: null,
        
        init() {
            // Initialize with current search query from URL
            const urlParams = new URLSearchParams(window.location.search);
            this.query = urlParams.get('q') || '';
        },
        
        searchProducts() {
            // Clear previous timeout
            if (this.searchTimeout) {
                clearTimeout(this.searchTimeout);
            }
            
            // Hide suggestions if query is empty
            if (this.query.length < 1) {
                this.showSuggestions = false;
                this.suggestions = [];
                return;
            }
            
            this.showSuggestions = true;
            this.isLoading = true;
            
            // Reduced debounce time for instant feel (like IKEA/Amazon)
            this.searchTimeout = setTimeout(() => {
                this.fetchSuggestions();
            }, 150);
        },
        
        async fetchSuggestions() {
            if (this.query.length < 1) return;
            
            this.isLoading = true;
            
            try {
                const baseUrl = window.APP_URL || '';
                const response = await fetch(`${baseUrl}/api/search-suggestions?q=${encodeURIComponent(this.query)}`);
                const data = await response.json();
                
                if (data.success) {
                    this.suggestions = data.suggestions.slice(0, 5).map(product => ({
                        id: product.id,
                        name: product.name,
                        price: parseInt(product.price),
                        sale_price: product.sale_price ? parseInt(product.sale_price) : null,
                        category: product.category ? product.category.name : '',
                        image: this.getValidImage(product.images)
                    }));
                } else {
                    this.suggestions = [];
                }
            } catch (error) {
                console.error('Search suggestions error:', error);
                this.suggestions = [];
            } finally {
                this.isLoading = false;
            }
        },
        
        getValidImage(images) {
            if (!images || images.length === 0) return null;
            const imagePath = images[0].image_path;
            if (!imagePath || imagePath.includes('placeholder')) return null;
            return imagePath;
        },
        
        selectSuggestion(suggestion) {
            this.query = suggestion.name;
            this.showSuggestions = false;
            window.location.href = `/products/${suggestion.id}`;
        },
        
        hideSuggestions() {
            setTimeout(() => {
                this.showSuggestions = false;
            }, 200);
        },
        
        // Handle form submission - redirect to products page with search
        submitSearch() {
            if (this.query.trim()) {
                this.showSuggestions = false;
                this.redirectToProductsPage();
            }
        },

        // Redirect to products page with search filter
        redirectToProductsPage() {
            const searchParams = new URLSearchParams();
            searchParams.set('search', this.query.trim());
            window.location.href = `/products?${searchParams.toString()}`;
        }
    }
}

// Mobile Search Box Component
function mobileSearchBox() {
    return {
        query: '',
        suggestions: [],
        showSuggestions: false,
        isLoading: false,
        searchTimeout: null,
        
        init() {
            // Initialize with current search query from URL
            const urlParams = new URLSearchParams(window.location.search);
            this.query = urlParams.get('q') || '';
        },
        
        searchProducts() {
            // Clear previous timeout
            if (this.searchTimeout) {
                clearTimeout(this.searchTimeout);
            }
            
            // Hide suggestions if query is empty
            if (this.query.length < 1) {
                this.showSuggestions = false;
                this.suggestions = [];
                return;
            }
            
            this.showSuggestions = true;
            this.isLoading = true;
            
            // Reduced debounce time for instant feel
            this.searchTimeout = setTimeout(() => {
                this.fetchSuggestions();
            }, 150);
        },
        
        async fetchSuggestions() {
            if (this.query.length < 1) return;
            
            this.isLoading = true;
            
            try {
                const baseUrl = window.APP_URL || '';
                const response = await fetch(`${baseUrl}/api/search-suggestions?q=${encodeURIComponent(this.query)}`);
                const data = await response.json();
                
                if (data.success) {
                    this.suggestions = data.suggestions.slice(0, 5).map(product => ({
                        id: product.id,
                        name: product.name,
                        price: parseInt(product.price),
                        sale_price: product.sale_price ? parseInt(product.sale_price) : null,
                        category: product.category ? product.category.name : '',
                        image: this.getValidImage(product.images)
                    }));
                } else {
                    this.suggestions = [];
                }
            } catch (error) {
                console.error('Search suggestions error:', error);
                this.suggestions = [];
            } finally {
                this.isLoading = false;
            }
        },
        
        getValidImage(images) {
            if (!images || images.length === 0) return null;
            const imagePath = images[0].image_path;
            if (!imagePath || imagePath.includes('placeholder')) return null;
            return imagePath;
        },
        
        selectSuggestion(suggestion) {
            this.query = suggestion.name;
            this.showSuggestions = false;
            window.location.href = `/products/${suggestion.id}`;
        },
        
        hideSuggestions() {
            setTimeout(() => {
                this.showSuggestions = false;
            }, 200);
        },
        
        // Handle form submission - redirect to products page with search
        submitSearch() {
            if (this.query.trim()) {
                this.showSuggestions = false;
                this.redirectToProductsPage();
            }
        },

        // Redirect to products page with search filter
        redirectToProductsPage() {
            const searchParams = new URLSearchParams();
            searchParams.set('search', this.query.trim());
            window.location.href = `/products?${searchParams.toString()}`;
        }
    }
}

// Initialize search functionality when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    console.log('Search functionality initialized');
});
