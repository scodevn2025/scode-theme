# SCODE Theme - WooCommerce Product Display

## 📋 Mô tả
Theme WordPress tùy chỉnh cho website bán hàng công nghệ, hiển thị sản phẩm với layout chuyên nghiệp và responsive design.

## ✨ Tính năng chính
- **Product Display**: Hiển thị sản phẩm theo sections (Flash Sale, Bán chạy, Giảm giá sốc, Sản phẩm mới)
- **Responsive Design**: Tối ưu cho Desktop (6 cột), Tablet (2 cột), Mobile (1 cột)
- **Dynamic Product Cards**: Thẻ sản phẩm với overlay elements động
- **WooCommerce Integration**: Tích hợp đầy đủ với WooCommerce
- **Custom Styling**: CSS variables và design system nhất quán

## 🚀 Cài đặt

### 1. Yêu cầu hệ thống
- WordPress 5.0+
- WooCommerce 6.0+
- PHP 7.4+
- MySQL 5.7+

### 2. Cài đặt theme
1. Upload thư mục `scode-theme` vào `/wp-content/themes/`
2. Kích hoạt theme trong WordPress Admin
3. Cài đặt và kích hoạt WooCommerce plugin
4. Thiết lập WooCommerce cơ bản

### 3. Thiết lập WooCommerce
```php
// Vào WooCommerce → Settings → General
Currency: VND (Vietnamese Dong)
Currency position: Right
Thousand separator: .
Decimal separator: ,
Number of decimals: 0
```

## 📁 Cấu trúc thư mục
```
scode-theme/
├── index.php              # Trang chủ với product sections
├── style.css              # CSS chính của theme
├── functions.php          # Functions và hooks
├── header.php             # Header template
├── footer.php             # Footer template
├── sidebar.php            # Sidebar template
├── woocommerce.php        # WooCommerce template
├── template-parts/        # Template parts
│   └── product-card.php   # Product card template
├── woocommerce/           # WooCommerce overrides
├── assets/                # Static assets
│   ├── css/              # CSS files
│   ├── js/               # JavaScript files
│   ├── images/           # Image files
│   └── fonts/            # Font files
└── inc/                   # Include files
```

## 🎨 Product Sections

### 1. Flash Sale Section
- Hiển thị 6 sản phẩm flash sale
- Tags: `flash-sale`, `khuyen-mai`, `sale`
- Layout: 1 hàng, 6 cột

### 2. Bán chạy Section
- Hiển thị 6 sản phẩm bán chạy
- Sử dụng function `scode_get_best_selling_products()`
- Layout: 1 hàng, 6 cột

### 3. Giảm giá sốc Section
- Hiển thị 6 sản phẩm giảm giá
- Tags: `robot-cao-cap`, `robot-sang-trong`
- Layout: 1 hàng, 6 cột

### 4. Sản phẩm mới Section
- Hiển thị 6 sản phẩm mới
- Tags: `vot_san-pham-vua-ra-mat`
- Layout: 1 hàng, 6 cột

## 🏷️ Product Tags System

### Tags khuyến mãi
- `flash-sale`: Sản phẩm flash sale
- `khuyen-mai`: Sản phẩm khuyến mãi
- `sale`: Sản phẩm giảm giá
- `vot_tro-gia-1-000-000d`: Trợ giá 1 triệu
- `vot_tro-gia-500-000d`: Trợ giá 500k

### Tags sản phẩm
- `robot-hut-bui`: Robot hút bụi
- `robot-lau-nha`: Robot lau nhà
- `robot-cao-cap`: Robot cao cấp
- `robot-ai-3d`: Robot AI 3D
- `may-loc-khong-khi`: Máy lọc không khí
- `may-loc-nuoc`: Máy lọc nước
- `smartwatch`: Smartwatch
- `phu-kien`: Phụ kiện

## 🎯 Product Card Features

### Overlay Elements
- **Logo**: Tên thương hiệu (MI VIETNAM.VN)
- **Medal Icon**: Trạng thái bảo hành
- **Global Week Label**: Nhãn khuyến mãi động
- **Discount Strip**: Dải giảm giá % (nếu có)
- **Gift Box Icon**: Icon quà tặng (nếu có khuyến mãi)
- **Horizontal Ribbon**: Ruy băng "Hot Sale" + "Mã giảm giá"

### Dynamic Data
- Tên sản phẩm (2 dòng, truncate)
- Giá khuyến mãi (màu cam đậm)
- Giá gốc (màu xám, gạch ngang)
- Phần trăm giảm giá (tự động tính)

## 🔧 Custom Functions

### 1. Best Selling Products
```php
function scode_get_best_selling_products($limit = 6) {
    $args = array(
        'post_type' => 'product',
        'posts_per_page' => $limit,
        'post_status' => 'publish',
        'meta_key' => 'total_sales',
        'orderby' => 'meta_value_num',
        'order' => 'DESC'
    );
    
    return new WP_Query($args);
}
```

### 2. Products by Tag
```php
function scode_get_products_by_tag($tag_slug, $limit = 6) {
    $args = array(
        'post_type' => 'product',
        'posts_per_page' => $limit,
        'post_status' => 'publish',
        'tax_query' => array(
            array(
                'taxonomy' => 'product_tag',
                'field' => 'slug',
                'terms' => $tag_slug
            )
        )
    );
    
    return new WP_Query($args);
}
```

## 🎨 CSS Variables

### Color System
```css
:root {
    --color-primary: #FF6B35;      /* Cam chính */
    --color-danger: #E53935;       /* Đỏ dải giảm giá */
    --color-text: #111827;         /* Tiêu đề */
    --color-muted: #9CA3AF;        /* Giá gốc */
    --surface: #FFFFFF;             /* Nền trắng */
}
```

### Container System
```css
:root {
    --container-width: 1200px;
    --container-padding: 0 20px;
    --container-radius: 12px;
    --container-shadow: 0 4px 20px rgba(0,0,0,0.1);
}
```

## 📱 Responsive Design

### Breakpoints
- **Desktop**: ≥1200px (6 cột)
- **Tablet**: 768px - 1199px (2 cột)
- **Mobile**: <768px (1 cột)

### Grid System
```css
.products-grid {
    display: grid;
    gap: 20px;
    grid-template-columns: repeat(6, 1fr);
}

@media (max-width: 1199px) {
    .products-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 767px) {
    .products-grid {
        grid-template-columns: 1fr;
    }
}
```

## ⚠️ Troubleshooting

### Sản phẩm không hiển thị
1. Kiểm tra trạng thái sản phẩm (Published)
2. Kiểm tra tags và categories
3. Xóa cache website
4. Kiểm tra console browser

### Hình ảnh không hiển thị
1. Re-upload hình ảnh
2. Kiểm tra quyền thư mục (755)
3. Xóa cache
4. Kiểm tra plugin tối ưu hóa

### Layout bị vỡ
1. Kiểm tra console browser
2. Tắt plugin một cách
3. Kiểm tra theme compatibility
4. Cập nhật theme và plugin

## 🚀 Performance Optimization

### 1. Image Optimization
- Kích thước khuyến nghị: 800x800px
- Format: JPG, PNG
- Dung lượng: < 500KB
- Lazy loading

### 2. CSS Optimization
- Minify CSS
- Critical CSS inline
- Unused CSS removal

### 3. JavaScript Optimization
- Minify JS
- Defer non-critical JS
- Remove unused JS

## 📊 Testing Tools

### Performance Testing
- Google PageSpeed Insights
- GTmetrix
- WebPageTest

### Browser Testing
- Chrome DevTools
- Firefox Developer Tools
- Safari Web Inspector

### Mobile Testing
- Chrome DevTools Mobile
- BrowserStack
- LambdaTest

## 🔄 Development Workflow

### 1. Local Development
1. Setup XAMPP/WAMP
2. Clone repository
3. Import database
4. Configure WordPress

### 2. Testing
1. Test trên local
2. Kiểm tra responsive
3. Test performance
4. Cross-browser testing

### 3. Deployment
1. Backup production
2. Upload files
3. Update database
4. Test production

## 📝 Changelog

### Version 3.1.0
- Thêm dynamic data cho product cards
- Cải thiện responsive design
- Tối ưu hóa performance

### Version 3.0.0
- Redesign product card layout
- Thêm overlay elements
- Implement CSS variables system

### Version 2.0.0
- Refactor index.php với template parts
- Thêm product sections
- Implement WooCommerce integration

## 🤝 Contributing

### Code Standards
- PHP: PSR-12
- CSS: BEM methodology
- JavaScript: ES6+
- HTML: Semantic HTML5

### Git Workflow
1. Create feature branch
2. Make changes
3. Test locally
4. Create pull request
5. Code review
6. Merge to main

## 📄 License

This project is licensed under the GPL v2 or later.

## 📞 Support

### Documentation
- [WordPress Theme Development](https://developer.wordpress.org/themes/)
- [WooCommerce Documentation](https://docs.woocommerce.com/)
- [Theme Customization](https://developer.wordpress.org/themes/customize-api/)

### Issues
- Create issue trên GitHub
- Mô tả chi tiết vấn đề
- Cung cấp screenshot nếu cần
- Ghi rõ environment và version

---

*Theme được phát triển bởi SCODE Team*
*Cập nhật lần cuối: <?php echo date('d/m/Y'); ?>*
