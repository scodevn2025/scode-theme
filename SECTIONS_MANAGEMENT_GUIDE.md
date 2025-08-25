# 🎨 HƯỚNG DẪN QUẢN LÝ SECTIONS TRONG ADMIN CP

## **📋 TỔNG QUAN HỆ THỐNG**

Hệ thống quản lý sections mới cho phép bạn:
- ✅ **Thêm/Sửa/Xóa** các sections từ Admin CP
- ✅ **Tùy chỉnh màu sắc** cho từng section
- ✅ **Sắp xếp thứ tự** hiển thị
- ✅ **Kích hoạt/Vô hiệu hóa** sections
- ✅ **Quản lý nội dung** một cách dễ dàng

## **🚀 CÁC LOẠI SECTIONS CÓ SẴN**

### **1. Hero Section**
- **Vị trí**: Đầu trang chủ
- **Chức năng**: Banner chính, slider, call-to-action
- **Tùy chỉnh**: Tiêu đề, mô tả, nút, màu sắc, hình ảnh

### **2. Promo Banner**
- **Vị trí**: Giữa các section sản phẩm
- **Chức năng**: Quảng cáo, khuyến mãi, thông báo
- **Tùy chỉnh**: Tiêu đề, mô tả, nút, màu nền, màu chữ

### **3. Service Icon**
- **Vị trí**: Phần dịch vụ (icons row)
- **Chức năng**: Hiển thị các dịch vụ của công ty
- **Tùy chỉnh**: Icon, tiêu đề, mô tả, màu sắc

### **4. Category Item**
- **Vị trí**: Phần danh mục nổi bật
- **Chức năng**: Hiển thị các danh mục sản phẩm
- **Tùy chỉnh**: Icon, tên, mô tả, màu sắc, URL

## **🎯 CÁCH SỬ DỤNG ADMIN CP**

### **Bước 1: Truy cập Admin CP**
```
WordPress Admin → [Menu mới xuất hiện]
├── Hero Sections
├── Promo Banners  
├── Service Icons
└── Category Items
```

### **Bước 2: Thêm Section Mới**
1. Click **"Thêm mới"**
2. Điền **Tiêu đề** (bắt buộc)
3. Điền **Nội dung** (mô tả chi tiết)
4. **Đặt hình ảnh** (Featured Image)
5. Cấu hình **Meta Fields** bên phải

### **Bước 3: Cấu hình Meta Fields**

#### **Hero Section:**
```
Tiêu đề chính: [Text] - Tiêu đề lớn hiển thị
Tiêu đề phụ: [Text] - Tiêu đề nhỏ bên dưới
Text nút: [Text] - Text hiển thị trên nút
URL nút: [URL] - Liên kết khi click nút
Màu nền: [Color Picker] - Màu nền section
Màu chữ: [Color Picker] - Màu chữ
Thứ tự: [Number] - Thứ tự hiển thị (1, 2, 3...)
Kích hoạt: [Checkbox] - Bật/tắt section
```

#### **Promo Banner:**
```
Tiêu đề: [Text] - Tiêu đề banner
Mô tả: [Textarea] - Mô tả chi tiết
Text nút: [Text] - Text nút
URL nút: [URL] - Liên kết nút
Màu nền: [Color Picker] - Màu nền banner
Màu chữ: [Color Picker] - Màu chữ
Thứ tự: [Number] - Thứ tự hiển thị
Kích hoạt: [Checkbox] - Bật/tắt banner
```

#### **Service Icon:**
```
Tiêu đề: [Text] - Tên dịch vụ
Mô tả: [Textarea] - Mô tả dịch vụ
Icon: [Text] - Class FontAwesome (vd: fas fa-truck)
Text nút: [Text] - Text nút
URL nút: [URL] - Liên kết nút
Màu nền icon: [Color Picker] - Màu nền icon
Màu icon: [Color Picker] - Màu icon
Thứ tự: [Number] - Thứ tự hiển thị
Kích hoạt: [Checkbox] - Bật/tắt dịch vụ
```

#### **Category Item:**
```
Tiêu đề: [Text] - Tên danh mục
Mô tả: [Textarea] - Mô tả danh mục
Icon: [Text] - Class FontAwesome (vd: fas fa-robot)
URL danh mục: [URL] - Liên kết danh mục
Màu nền: [Color Picker] - Màu nền category
Màu icon: [Color Picker] - Màu icon
Thứ tự: [Number] - Thứ tự hiển thị
Kích hoạt: [Checkbox] - Bật/tắt danh mục
```

## **🎨 HỆ THỐNG MÀU SẮC MỚI**

### **Background Colors:**
- **`--otnt-bg-primary`**: #ffffff (Trắng - Nội dung chính)
- **`--otnt-bg-secondary`**: #f7fafc (Xám nhạt - Background trang)
- **`--otnt-bg-tertiary`**: #edf2f7 (Xám trung bình - Background section)
- **`--otnt-bg-accent`**: #fff5f0 (Cam nhạt - Background accent)
- **`--otnt-bg-card`**: #ffffff (Trắng - Background card)
- **`--otnt-bg-sidebar`**: #f8fafc (Xám nhạt - Background sidebar)

### **Text Colors:**
- **`--otnt-text-primary`**: #1a202c (Đen đậm - Tiêu đề chính)
- **`--otnt-text-secondary`**: #4a5568 (Xám đậm - Tiêu đề phụ)
- **`--otnt-text-tertiary`**: #718096 (Xám nhạt - Mô tả)

### **Border Colors:**
- **`--otnt-border-light`**: #e2e8f0 (Xám rất nhạt - Border mỏng)
- **`--otnt-border-medium`**: #cbd5e0 (Xám nhạt - Border trung bình)
- **`--otnt-border-accent`**: rgba(243, 108, 33, 0.2) (Cam trong suốt)

## **🔧 CÁC TÍNH NĂNG NÂNG CAO**

### **1. Thứ tự hiển thị:**
- Sử dụng số **1, 2, 3...** để sắp xếp
- Số nhỏ hơn hiển thị trước
- Có thể dùng số thập phân (1.5, 2.5...)

### **2. Kích hoạt/Vô hiệu hóa:**
- **Checkbox bật**: Section hiển thị
- **Checkbox tắt**: Section ẩn hoàn toàn
- Có thể ẩn tạm thời mà không cần xóa

### **3. Responsive Design:**
- Tự động điều chỉnh theo màn hình
- Mobile: 1 cột
- Tablet: 2-3 cột  
- Desktop: 4-5 cột

## **📱 RESPONSIVE BREAKPOINTS**

```css
/* Desktop */
@media (min-width: 992px) {
    .icons-grid { grid-template-columns: repeat(4, 1fr); }
    .categories-grid { grid-template-columns: repeat(5, 1fr); }
}

/* Tablet */
@media (max-width: 991px) {
    .icons-grid { grid-template-columns: repeat(2, 1fr); }
    .categories-grid { grid-template-columns: repeat(3, 1fr); }
}

/* Mobile */
@media (max-width: 767px) {
    .icons-grid { grid-template-columns: 1fr; }
    .categories-grid { grid-template-columns: repeat(2, 1fr); }
}

/* Small Mobile */
@media (max-width: 479px) {
    .categories-grid { grid-template-columns: 1fr; }
}
```

## **🎯 VÍ DỤ THỰC TẾ**

### **Tạo Service Icon "Giao hàng nhanh":**
```
Tiêu đề: Giao hàng nhanh
Mô tả: 2-4h nội thành, 1-2 ngày toàn quốc
Icon: fas fa-truck
Text nút: Tìm hiểu thêm
URL nút: /van-chuyen
Màu nền icon: #f36c21
Màu icon: #ffffff
Thứ tự: 1
Kích hoạt: ✓
```

### **Tạo Category "Robot hút bụi":**
```
Tiêu đề: Robot hút bụi
Mô tả: Các loại robot hút bụi thông minh
Icon: fas fa-robot
URL danh mục: /danh-muc/robot-hut-bui
Màu nền: #f36c21
Màu icon: #ffffff
Thứ tự: 1
Kích hoạt: ✓
```

## **⚠️ LƯU Ý QUAN TRỌNG**

1. **Luôn lưu** sau khi thay đổi
2. **Kiểm tra preview** trước khi publish
3. **Sử dụng màu sắc** phù hợp với brand
4. **Tối ưu hình ảnh** để tăng tốc độ
5. **Test responsive** trên nhiều thiết bị

## **🚀 KẾT LUẬN**

Hệ thống mới giúp:
- ✅ **Quản lý dễ dàng** hơn qua Admin CP
- ✅ **Màu sắc hài hòa** và phân biệt rõ ràng
- ✅ **Responsive hoàn hảo** trên mọi thiết bị
- ✅ **Tùy chỉnh linh hoạt** theo ý muốn
- ✅ **Hiệu suất cao** với CSS variables

**Bắt đầu sử dụng ngay để tạo website chuyên nghiệp và hấp dẫn! 🎉**
