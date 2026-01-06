// js/products.js
export const products = [
    {
        id: 1,
        name: "Premium Leather Seat Covers",
        description: "Transform your car interior with our premium leather seat covers. Designed for durability and maximum comfort, these covers are breathable, water-resistant, and easy to clean.",
        price: 189.99,
        image: "https://images.unsplash.com/photo-1618843479313-40f8afb4b4d8?w=800&q=80",
        category: "Interior",
        badge: "Best Seller",
        tags: ["leather", "premium", "interior"]
    },
    {
        id: 2,
        name: "All-Weather Floor Mats Pro",
        description: "Heavy-duty protection for your vehicle floor. Deep channels trap water, mud, and debris. Custom fit for most sedans and SUVs.",
        price: 49.99,
        image: "https://images.unsplash.com/photo-1619642751034-765dfdf7c58e?w=800&q=80",
        category: "Interior",
        badge: "Best Seller",
        tags: ["floor", "protection", "interior"]
    },
    {
        id: 3,
        name: "Smart Trunk Organizer",
        description: "Keep your trunk clutter-free. Collapsible design with multiple compartments, sturdy handles, and non-slip bottom strips.",
        price: 34.99,
        image: "https://images.unsplash.com/photo-1581235720704-06d3acfcb36f?w=800&q=80",
        category: "Storage",
        tags: ["storage", "organizer", "trunk"]
    },
    {
        id: 4,
        name: "MagSafe Dashboard Mount",
        description: "Secure magnetic phone mount with 360-degree rotation. Industrial-strength suction cup adheres to dashboard or windshield.",
        price: 29.99,
        image: "https://images.unsplash.com/photo-1598327105666-5b89351aff97?w=800&q=80",
        category: "Electronics",
        badge: "Best Seller",
        tags: ["mount", "phone", "electronics"]
    },
    {
        id: 5,
        name: "RGB Ambient Lighting Kit",
        description: "App-controlled LED interior lights with music sync mode. Choose from 16 million colors to match your mood.",
        price: 39.99,
        image: "https://images.unsplash.com/photo-1492144534655-ae79c964c9d7?w=800&q=80",
        category: "Electronics",
        tags: ["lighting", "rgb", "electronics"]
    },
    {
        id: 6,
        name: "HEPA Car Air Purifier",
        description: "Eliminate odors, smoke, and allergens. Portable design fits in cup holder. USB powered with quiet operation.",
        price: 59.99,
        image: "https://images.unsplash.com/photo-1556656793-08538906a9f8?w=800&q=80",
        category: "Electronics",
        tags: ["air", "purifier", "electronics"]
    },
    {
        id: 7,
        name: "Backseat Tablet Organizer",
        description: "Perfect for road trips with kids. Holds tablets up to 11 inches, drinks, snacks, and toys. Durable waterproof fabric.",
        price: 29.99,
        image: "https://images.unsplash.com/photo-1552519507-da3b142c6e3d?w=800&q=80",
        category: "Storage",
        badge: "Best Seller",
        tags: ["tablet", "organizer", "kids"]
    }
];

// Product utility functions
export function getProductById(id) {
    return products.find(product => product.id === id);
}

export function getProductsByCategory(category) {
    return products.filter(product => product.category === category);
}

export function getFeaturedProducts() {
    return products.filter(product => product.badge === "Best Seller");
}