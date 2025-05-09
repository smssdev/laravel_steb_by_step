# 

المرحلة الأولى - الدرس الثاني: مفهوم MVC (Model-View-Controller)
مرحباً بك في الدرس الثاني من رحلة تعلم Laravel! بعد أن تعرفنا على أساسيات PHP و Laravel في الدرس السابق، سنتعرف اليوم على أحد أهم المفاهيم في تطوير تطبيقات الويب وهو نمط التصميم MVC.
ما هو نمط MVC؟
MVC هو اختصار لـ (Model-View-Controller) أو (النموذج-العرض-المتحكم) وهو نمط تصميم برمجي يُستخدم لتنظيم الكود وفصل مسؤوليات التطبيق إلى ثلاثة مكونات رئيسية:

النموذج (Model): مسؤول عن التعامل مع البيانات وقاعدة البيانات
العرض (View): مسؤول عن عرض البيانات للمستخدم (واجهة المستخدم)
المتحكم (Controller): مسؤول عن معالجة طلبات المستخدم وتنسيق العمل بين النموذج والعرض

مميزات استخدام نمط MVC

الفصل بين المسؤوليات: كل جزء له مهمة محددة
قابلية الصيانة: سهولة تعديل وصيانة الكود
إعادة استخدام الكود: يمكن إعادة استخدام المكونات في أماكن مختلفة
تطوير متوازٍ: يمكن لعدة مطورين العمل على أجزاء مختلفة في نفس الوقت
قابلية الاختبار: سهولة اختبار كل مكون بشكل منفصل

كيف يعمل MVC في Laravel؟
1. دورة حياة الطلب في Laravel
عندما يصل طلب إلى تطبيق Laravel، يتم معالجته على النحو التالي:

يستقبل الخادم الطلب ويوجهه إلى نقطة الدخول (public/index.php)
يقوم نظام التوجيه (Router) بتحديد المتحكم المسؤول عن معالجة الطلب
يقوم المتحكم بالتفاعل مع النموذج لجلب أو تعديل البيانات
يقوم المتحكم بتمرير البيانات إلى العرض
يقوم العرض بتنسيق البيانات وعرضها للمستخدم


# php artisan make:model article -mc
