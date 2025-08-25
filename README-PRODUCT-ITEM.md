# Product Item Structure - SCODE Theme

## Tổng quan

Cấu trúc `product-item` mới được thiết kế để thay thế cấu trúc `product-card` cũ, cung cấp giao diện hiện đại hơn với kích thước chuẩn 210x290px và khoảng cách tối ưu 16px giữa các card.

## Tính năng chính

### 🎯 Kích thước và Layout
- **Kích thước chuẩn:** 210x290px cho mỗi card
- **Khoảng cách:** 16px giữa các card (gap: 16px)
- **Grid system:** Hỗ trợ từ 2-6 cột với responsive
- **Aspect ratio:** Ảnh sản phẩm 9:16 (180px x 110px)

### 🎨 UI/UX Elements
- **Badges:** Sale, New, Stock status với vị trí tối ưu
- **Heart button:** Nút yêu thích với animation và localStorage
- **Add to cart:** Nút thêm vào giỏ với AJAX và feedback
- **Hover effects:** Zoom ảnh, nâng card, animation badges

### 📱 Responsive Design
- **1200px+:** 6 cột (cols-6)
- **992px-1199px:** 5 cột (cols-5)
- **768px-991px:** 4 cột (cols-4)
- **576px-767px:** 3 cột (cols-3)
- **576px-:** 2 cột (cols-2)

## Cách sử dụng

### 1. Render một sản phẩm đơn lẻ

```php
<?php
// Trong WordPress loop
while ($products->have_posts()) : $products->the_post();
    scode_render_product_item(get_the_ID());
endwhile;
wp_reset_postdata();
?>
```

### 2. Render grid sản phẩm

```php
<?php
// Lấy danh sách product IDs
$product_ids = array(123, 456, 789);

// Render grid với 6 cột
echo scode_get_product_items_grid($product_ids, 6, 'custom-class');

// Render grid với 4 cột
echo scode_get_product_items_grid($product_ids, 4);
?>
```

### 3. Sử dụng trực tiếp trong template

```php
<?php
global $product;
if ($product) :
    include get_template_directory() . '/template-parts/product-item.php';
endif;
?>
```

## Cấu trúc HTML

```html
<div class="product-item">
    <div class="product-item-photo">
        <!-- Sale badge -->
        <span class="onsale">-20%</span>
        
        <!-- New badge -->
        <span class="new-badge">Mới</span>
        
        <!-- Product image -->
        <a href="<?php echo get_permalink(); ?>">
            <img src="..." alt="..." class="product-item-img">
        </a>
        
        <!-- Sale icon -->
        <div class="sale-program-image-icon">
            <i class="fas fa-tags"></i>
        </div>
        
        <!-- Stock status -->
        <span class="stocks low-stock">Chỉ còn 3</span>
        
        <!-- Heart button -->
        <button class="heart-btn" data-product-id="123">
            <i class="far fa-heart"></i>
        </button>
    </div>
    
    <div class="product-item-detail">
        <!-- Product title -->
        <h3 class="woocommerce-loop-product__title">
            <a href="<?php echo get_permalink(); ?>"><?php the_title(); ?></a>
        </h3>
        
        <!-- Product price -->
        <div class="price product-item-price">
            <span class="sale-price">1,500,000đ</span>
            <span class="regular-price">1,900,000đ</span>
        </div>
        
        <!-- Add to cart button -->
        <button class="add-to-cart-btn" data-product-id="123">
            <i class="fas fa-shopping-cart"></i>
            Thêm vào giỏ
        </button>
    </div>
</div>
```

## CSS Classes

### Grid Container
- `.product-items-grid` - Container chính
- `.product-items-grid.cols-2` - 2 cột
- `.product-items-grid.cols-3` - 3 cột
- `.product-items-grid.cols-4` - 4 cột
- `.product-items-grid.cols-5` - 5 cột
- `.product-items-grid.cols-6` - 6 cột

### Product Card
- `.product-item` - Card sản phẩm
- `.product-item-photo` - Container ảnh
- `.product-item-img` - Ảnh sản phẩm
- `.product-item-detail` - Thông tin sản phẩm

### Badges và Elements
- `.onsale` - Badge giảm giá
- `.new-badge` - Badge sản phẩm mới
- `.stocks` - Badge trạng thái kho
- `.stocks.out-of-stock` - Hết hàng
- `.stocks.low-stock` - Sắp hết hàng
- `.sale-program-image-icon` - Icon chương trình khuyến mãi

### Buttons
- `.heart-btn` - Nút yêu thích
- `.heart-btn.active` - Trạng thái đã yêu thích
- `.add-to-cart-btn` - Nút thêm vào giỏ
- `.add-to-cart-btn:disabled` - Trạng thái loading
- `.add-to-cart-btn.success` - Trạng thái thành công

## JavaScript Features

### Heart Button
- Toggle yêu thích với localStorage
- Animation pulse khi click
- Tự động load trạng thái từ localStorage

### Add to Cart
- AJAX request với loading state
- Feedback messages (success/error)
- Cập nhật cart count
- Animation success

### Hover Effects
- Smooth transitions
- Image zoom effect
- Badge bounce animation
- Card lift effect

## Tích hợp WooCommerce

### Tự động lấy thông tin
```php
$product = wc_get_product($product_id);
$regular_price = $product->get_regular_price();
$sale_price = $product->get_sale_price();
$stock_status = $product->get_stock_status();
$stock_quantity = $product->get_stock_quantity();
```

### Sử dụng function có sẵn
```php
// Lấy ảnh sản phẩm với fallback
scode_get_simple_product_image($product_id, 'product-thumb', 'product-item-img');
```

## Tùy chỉnh

### Thêm badge mới
```css
.product-item-photo .custom-badge {
    position: absolute;
    top: 8px;
    left: 50px;
    background: #your-color;
    color: white;
    padding: 4px 8px;
    border-radius: 12px;
    font-size: 0.75rem;
    font-weight: 700;
    z-index: 3;
}
```

### Thay đổi màu sắc
```css
:root {
    --color-primary: #your-primary-color;
    --color-secondary: #your-secondary-color;
    --color-danger: #your-danger-color;
    --color-success: #your-success-color;
    --color-warning: #your-warning-color;
}
```

### Thay đổi kích thước
```css
.product-item {
    width: 250px;  /* Thay đổi width */
    height: 350px; /* Thay đổi height */
}

.product-items-grid {
    gap: 20px;     /* Thay đổi khoảng cách */
}
```

## Troubleshooting

### Ảnh không hiển thị
- Kiểm tra function `scode_get_simple_product_image()`
- Đảm bảo WooCommerce đã được kích hoạt
- Kiểm tra console để tìm lỗi JavaScript

### CSS không áp dụng
- Kiểm tra file `style.css` đã được load
- Clear cache nếu sử dụng caching plugin
- Kiểm tra CSS specificity

### JavaScript không hoạt động
- Đảm bảo jQuery đã được load
- Kiểm tra file `product-item.js` đã được enqueue
- Kiểm tra console để tìm lỗi

## Migration từ product-card

### Thay thế trong template
```php
// Cũ
<article class="product-card">
    <!-- content -->
</article>

// Mới
<?php scode_render_product_item(get_the_ID()); ?>
```

### Thay thế trong CSS
```css
/* Cũ */
.product-card { ... }

/* Mới */
.product-item { ... }
```

## Performance

### Lazy Loading
- Ảnh sử dụng `loading="lazy"` mặc định
- JavaScript lazy loading có thể được tắt

### CSS Optimization
- Sử dụng CSS variables để dễ maintain
- Minimal CSS với focus vào performance
- Responsive design với media queries

### JavaScript Optimization
- Event delegation cho dynamic content
- Throttled hover effects
- Efficient DOM manipulation

## Browser Support

- **Modern browsers:** Full support
- **IE11+:** Partial support (CSS Grid fallback)
- **Mobile browsers:** Full responsive support

## License

Sử dụng theo license của SCODE Theme.

---

**Lưu ý:** Cấu trúc này được thiết kế để tương thích ngược với cấu trúc cũ. Bạn có thể sử dụng cả hai cấu trúc cùng lúc trong quá trình migration.
