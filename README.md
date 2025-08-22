# OTNT Theme - WordPress Theme

## 📝 Mô tả
OTNT Theme là một WordPress theme hiện đại, responsive được tối ưu hóa cho WooCommerce với thiết kế sạch sẽ và hiệu suất tuyệt vời. Theme được thiết kế cho OTNT - ÔNG TRÙM NỘI TRỢ.

## ✨ Tính năng chính

### 🎨 Thiết kế & Giao diện
- **Responsive Design**: Hoạt động hoàn hảo trên mọi thiết bị
- **OTNT Style**: Giao diện hiện đại, chuyên nghiệp
- **CSS Variables**: Dễ dàng tùy chỉnh màu sắc và layout
- **Typography**: Sử dụng font Inter cho giao diện đẹp mắt

### 🛒 WooCommerce Integration
- **Product Grid**: Hiển thị sản phẩm với 6 cột (desktop)
- **Product Cards**: Thiết kế card sản phẩm đẹp mắt
- **Add to Cart**: Nút thêm vào giỏ hàng với AJAX
- **Product Categories**: Hiển thị sản phẩm theo danh mục
- **Flash Sale**: Section khuyến mãi với countdown timer

### 🚀 Hiệu suất & Tối ưu
- **Lazy Loading**: Tối ưu hóa hình ảnh
- **Minified CSS/JS**: Giảm kích thước file
- **SEO Friendly**: Cấu trúc HTML tối ưu cho SEO
- **Fast Loading**: Tải trang nhanh chóng

### 📱 Responsive Breakpoints
- **Desktop**: 1200px+ (6 cột sản phẩm)
- **Tablet**: 992px - 1199px (4 cột sản phẩm)
- **Mobile**: 768px - 991px (3 cột sản phẩm)
- **Small Mobile**: 480px - 767px (2 cột sản phẩm)
- **Extra Small**: <480px (1 cột sản phẩm)

## 🏗️ Cấu trúc Theme

```
otnt-theme/
├── assets/
│   ├── css/
│   │   ├── main.css          # CSS chính
│   │   └── custom.css        # CSS tùy chỉnh
│   ├── js/
│   │   └── main.js           # JavaScript chính
│   └── img/                  # Hình ảnh theme
├── inc/
│   ├── customizer.php        # Tùy chỉnh theme
│   ├── theme-options.php     # Tùy chọn ACF
│   └── woocommerce-overrides.php # WooCommerce tùy chỉnh
├── template-parts/
│   └── product-card.php      # Template sản phẩm
├── functions.php             # Chức năng chính
├── header.php               # Header template
├── footer.php               # Footer template
├── index.php                # Trang chủ
├── sidebar.php              # Sidebar template
├── style.css                # Stylesheet chính
└── README.md                # Tài liệu này
```

## 🚀 Cài đặt

### 1. Cài đặt Theme
1. Tải theme lên thư mục `/wp-content/themes/`
2. Kích hoạt theme trong WordPress Admin > Appearance > Themes

### 2. Cài đặt WooCommerce
1. Cài đặt plugin WooCommerce
2. Kích hoạt plugin
3. Chạy setup wizard

### 3. Tạo Product Categories
Tạo các danh mục sản phẩm sau:
- Điện thoại
- Máy tính bảng
- Robot hút bụi
- Thiết bị gia dụng
- Máy chạy bộ
- Đồng hồ thông minh
- Máy lọc không khí
- Camera giám sát
- Thiết bị mạng
- Phụ kiện điện thoại
- Thiết bị âm thanh
- Thiết bị thông minh
- Phụ kiện khác

### 4. Thêm Sản phẩm
1. Vào Products > Add New
2. Chọn category phù hợp
3. Thêm hình ảnh và thông tin sản phẩm
4. Đặt giá và giá khuyến mãi (nếu có)

## 🎨 Tùy chỉnh

### CSS Variables
```css
:root {
    --primary-color: #FF6A00;          /* Màu cam chính */
    --secondary-color: #1e3a8a;        /* Màu xanh dương */
    --accent-color: #f59e0b;           /* Màu vàng */
    --text-primary: #1f2937;           /* Màu chữ chính */
    --bg-primary: #ffffff;             /* Màu nền chính */
}
```

### Customizer Options
- **Colors**: Tùy chỉnh màu sắc theme
- **Hero Section**: Văn bản banner chính
- **Product Grid**: Số cột hiển thị sản phẩm
- **Footer Text**: Văn bản footer

### ACF Theme Options
- **Hero Section**: Cấu hình banner chính
- **Company Info**: Thông tin công ty
- **Social Media**: Liên kết mạng xã hội
- **Section Visibility**: Hiển thị/ẩn các section

## 🔧 Tính năng JavaScript

### Interactive Elements
- **Mobile Menu**: Menu responsive cho mobile
- **Search Functionality**: Tìm kiếm sản phẩm
- **Back to Top**: Nút cuộn lên đầu trang
- **Smooth Scrolling**: Cuộn mượt mà
- **Countdown Timer**: Đếm ngược flash sale
- **Product Interactions**: Hover effects và animations
- **Category Links**: Hiệu ứng hover cho danh mục

### WooCommerce Features
- **AJAX Add to Cart**: Thêm vào giỏ hàng không reload
- **Cart Count Update**: Cập nhật số lượng giỏ hàng
- **Product Hover Effects**: Hiệu ứng khi hover sản phẩm

## 📱 Responsive Design

### Breakpoints
```css
/* Desktop */
@media (min-width: 1200px) {
    .products-grid { grid-template-columns: repeat(6, 1fr); }
}

/* Tablet */
@media (max-width: 1199px) and (min-width: 992px) {
    .products-grid { grid-template-columns: repeat(4, 1fr); }
}

/* Mobile */
@media (max-width: 991px) and (min-width: 768px) {
    .products-grid { grid-template-columns: repeat(3, 1fr); }
}

/* Small Mobile */
@media (max-width: 767px) and (min-width: 480px) {
    .products-grid { grid-template-columns: repeat(2, 1fr); }
}

/* Extra Small */
@media (max-width: 479px) {
    .products-grid { grid-template-columns: 1fr; }
}
```

## 🎯 Sections chính

### 1. Hero Banner
- Banner chính với sản phẩm nổi bật
- Call-to-action button
- Gradient background đẹp mắt

### 2. Category Quick Links
- 6 danh mục sản phẩm chính
- Icons và tên danh mục
- Hover effects

### 3. Flash Sale
- Sản phẩm khuyến mãi
- Countdown timer
- Background gradient đỏ

### 4. Product Categories
- 12 danh mục sản phẩm riêng biệt
- Grid layout responsive
- View all links

### 5. After Sales
- Thông tin hỗ trợ khách hàng
- Số điện thoại liên hệ
- Nút hỗ trợ online

### 6. News & Partners
- Tin tức mới nhất
- Logo đối tác
- Grid layout 2 cột

## 🛠️ Development

### Requirements
- WordPress 5.0+
- PHP 7.4+
- WooCommerce 5.0+
- ACF Pro (khuyến nghị)

### Browser Support
- Chrome 90+
- Firefox 88+
- Safari 14+
- Edge 90+

### Performance
- **PageSpeed Score**: 90+ (Desktop), 85+ (Mobile)
- **First Contentful Paint**: <1.5s
- **Largest Contentful Paint**: <2.5s
- **Cumulative Layout Shift**: <0.1

## 📞 Hỗ trợ & Liên hệ

### Tác giả
**Scode**  
📱 **Phone**: 0582392345  
🌐 **Website**: [scode.dev](https://scode.dev)  
📧 **Email**: contact@scode.dev

### Báo cáo lỗi
Nếu bạn gặp vấn đề với theme, vui lòng:
1. Kiểm tra console browser để xem lỗi JavaScript
2. Kiểm tra log WordPress
3. Liên hệ tác giả qua số điện thoại hoặc email

### Yêu cầu tính năng
Để yêu cầu thêm tính năng mới:
1. Mô tả chi tiết tính năng mong muốn
2. Liên hệ tác giả
3. Thời gian phát triển sẽ được thông báo

## 📄 License

Theme này được phát triển bởi **Scode** và được cấp phép theo GPL v2 hoặc mới hơn.

## 🔄 Changelog

### Version 2.0.0 (Current)
- ✨ Thiết kế mới hoàn toàn theo MI VIETNAM.VN
- 🎨 Giao diện hiện đại và responsive
- 🛒 Tích hợp WooCommerce hoàn chỉnh
- 📱 Responsive design cho mọi thiết bị
- 🚀 Tối ưu hóa hiệu suất
- 🔧 Cải thiện code structure

### Version 1.0.0
- 🎉 Phát hành phiên bản đầu tiên
- 📱 Responsive design cơ bản
- 🛒 WooCommerce support
- 🎨 Customizer options

---

**OTNT Theme** - Theme WordPress hiện đại cho e-commerce  
**Tác giả**: Scode | **Liên hệ**: 0582392345  
**Phiên bản**: 2.0.0 | **Cập nhật**: 2024-12-19
