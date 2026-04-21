/**
 * Modern Enterprise Analytics Dashboard
 * ApexCharts Refined Configuration
 */

document.addEventListener('DOMContentLoaded', function () {
    const configContainer = document.getElementById('analytics-config');
    if (!configContainer) return;

    const chartDataUrl = configContainer.dataset.url;
    let charts = {};

    // Vietnamese localization for ApexCharts
    const vnLocale = {
        name: 'vi',
        options: {
            months: ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6', 'Tháng 7', 'Tháng 8', 'Tháng 9', 'Tháng 10', 'Tháng 11', 'Tháng 12'],
            shortMonths: ['Th1', 'Th2', 'Th3', 'Th4', 'Th5', 'Th6', 'Th7', 'Th8', 'Th9', 'Th10', 'Th11', 'Th12'],
            days: ['Chủ Nhật', 'Thứ Hai', 'Thứ Ba', 'Thứ Tư', 'Thứ Năm', 'Thứ Sáu', 'Thứ Bảy'],
            shortDays: ['CN', 'T2', 'T3', 'T4', 'T5', 'T6', 'T7'],
            toolbar: {
                exportToSVG: 'Tải SVG',
                exportToPNG: 'Tải PNG',
                exportToCSV: 'Tải CSV',
                selection: 'Chọn',
                selectionZoom: 'Phóng chọn',
                zoomIn: 'Phóng to',
                zoomOut: 'Thu nhỏ',
                pan: 'Di chuyển',
                reset: 'Khôi phục',
            }
        }
    };

    const commonOptions = {
        chart: {
            locales: [vnLocale],
            defaultLocale: 'vi',
            fontFamily: 'Inter, system-ui, sans-serif',
            toolbar: { show: false },
            animations: {
                enabled: true,
                easing: 'easeout', // Smoother for enterprise
                speed: 600,
                animateGradually: { enabled: true, delay: 150 },
                dynamicAnimation: { enabled: true, speed: 350 }
            }
        },
        grid: {
            borderColor: '#f1f5f9',
            strokeDashArray: 4,
        },
        colors: ['#2563eb', '#10b981', '#6366f1', '#f59e0b', '#ef4444', '#64748b'],
    };

    // Initialize Charts
    function initCharts(data) {
        // 1. Revenue & Orders Trend
        const trendOptions = {
            ...commonOptions,
            series: [
                { name: 'Doanh thu', type: 'area', data: data.revenue_orders.revenue },
                { name: 'Đơn hàng', type: 'line', data: data.revenue_orders.orders }
            ],
            stroke: { 
                curve: 'smooth', 
                width: [2, 3],
                dashArray: [0, 0] 
            },
            fill: {
                type: 'gradient',
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.25,
                    opacityTo: 0.05,
                    stops: [0, 90, 100]
                }
            },
            markers: { size: 0, hover: { size: 5 } },
            labels: data.revenue_orders.labels,
            yaxis: [
                {
                    title: { text: null },
                    labels: {
                        formatter: (val) => new Intl.NumberFormat('vi-VN').format(val) + '₫',
                        style: { colors: '#64748b', fontWeight: 500 }
                    }
                },
                {
                    opposite: true,
                    title: { text: null },
                    labels: { 
                        formatter: (val) => Math.round(val),
                        style: { colors: '#64748b', fontWeight: 500 } 
                    }
                }
            ],
            xaxis: {
                axisBorder: { show: false },
                axisTicks: { show: false },
                labels: { style: { colors: '#94a3b8', fontWeight: 500 } }
            },
            tooltip: {
                theme: 'light',
                shared: true,
                intersect: false,
                y: {
                    formatter: function (y, { seriesIndex }) {
                        return seriesIndex === 0 ? new Intl.NumberFormat('vi-VN').format(y) + ' ₫' : y + ' đơn';
                    }
                }
            },
            legend: { 
                position: 'top', 
                horizontalAlign: 'right',
                fontWeight: 600,
                markers: { radius: 12 }
            }
        };
        charts.trend = new ApexCharts(document.querySelector("#chart-revenue-trend"), trendOptions);
        charts.trend.render();

        // 2. Top Sellers
        const barOptions = {
            ...commonOptions,
            chart: { ...commonOptions.chart, type: 'bar' },
            series: [{ name: 'Bán ra', data: data.top_sellers.map(i => i.value) }],
            plotOptions: {
                bar: {
                    borderRadius: 6,
                    horizontal: true,
                    barHeight: '45%',
                    distributed: true,
                }
            },
            dataLabels: { 
                enabled: true,
                textAnchor: 'start',
                style: { colors: ['#fff'], fontWeight: 700 },
                offsetX: 0,
                formatter: (val) => val + ' sp'
            },
            xaxis: {
                categories: data.top_sellers.map(i => i.name),
                labels: { show: false },
                axisBorder: { show: false },
            },
            yaxis: {
                labels: {
                    style: { fontWeight: 600, colors: '#475569' },
                    maxWidth: 160
                }
            },
            tooltip: { enabled: false },
            legend: { show: false }
        };
        charts.topSellers = new ApexCharts(document.querySelector("#chart-top-sellers"), barOptions);
        charts.topSellers.render();

        // 3. Order Status (Donut)
        const donutOptions = {
            ...commonOptions,
            chart: { ...commonOptions.chart, type: 'donut', height: 320 },
            series: data.order_status.values,
            labels: data.order_status.labels,
            stroke: { width: 0 },
            plotOptions: {
                pie: {
                    donut: {
                        size: '80%',
                        labels: {
                            show: true,
                            name: { show: true, fontSize: '12px', fontWeight: 600, color: '#94a3b8' },
                            value: { show: true, fontSize: '20px', fontWeight: 700, color: '#1e293b' },
                            total: {
                                show: true,
                                label: 'TỔNG ĐƠN',
                                formatter: (w) => w.globals.seriesTotals.reduce((a, b) => a + b, 0)
                            }
                        }
                    }
                }
            },
            dataLabels: { enabled: false },
            legend: { 
                position: 'bottom',
                fontSize: '13px',
                fontWeight: 500,
                markers: { radius: 12, width: 8, height: 8 }
            }
        };
        charts.status = new ApexCharts(document.querySelector("#chart-order-status"), donutOptions);
        charts.status.render();
        
        // Render Slow Sellers Table
        renderSlowSellers(data.slow_sellers);
    }

    function renderSlowSellers(items) {
        const container = document.querySelector("#slow-sellers-container");
        if (items.length === 0) {
            container.innerHTML = '<div class="col-span-3 text-center py-12 bg-white text-slate-400 font-medium">Không có dữ liệu cảnh báo</div>';
            return;
        }

        container.innerHTML = items.map(item => `
            <div class="bg-white p-6 transition-all hover:bg-slate-50 border-r last:border-r-0 border-slate-100">
                <div class="space-y-4">
                    <div class="min-w-0">
                        <p class="font-bold text-slate-900 truncate mb-1" title="${item.name}">${item.name}</p>
                        <div class="flex items-center gap-2">
                             <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-slate-100 text-slate-500 uppercase tracking-tight">Mã: SP-${Math.floor(Math.random() * 1000)}</span>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4 pt-2 border-t border-slate-50">
                        <div>
                            <p class="text-[10px] font-bold text-slate-400 uppercase mb-1">Tồn kho</p>
                            <p class="text-lg font-extrabold text-slate-900">${item.stock}</p>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold text-slate-400 uppercase mb-1">Bán trong kỳ</p>
                            <p class="text-lg font-extrabold text-red-500">${item.sold}</p>
                        </div>
                    </div>
                </div>
            </div>
        `).join('');
    }

    async function fetchData(params = {}) {
        const queryString = new URLSearchParams(params).toString();
        
        // Loader handling
        const loader = document.querySelector('.chart-loading');
        if (loader) loader.classList.remove('hidden');
        document.querySelectorAll('.chart-content').forEach(el => el.style.opacity = '0.5');

        try {
            const response = await fetch(`${chartDataUrl}?${queryString}`);
            const data = await response.json();

            if (!charts.trend) {
                initCharts(data);
            } else {
                updateCharts(data);
            }
        } catch (error) {
            console.error('Data Fetch Error:', error);
        } finally {
            if (loader) loader.classList.add('hidden');
            document.querySelectorAll('.chart-content').forEach(el => el.style.opacity = '1');
        }
    }

    function updateCharts(data) {
        charts.trend.updateOptions({
            series: [
                { name: 'Doanh thu', data: data.revenue_orders.revenue },
                { name: 'Đơn hàng', data: data.revenue_orders.orders }
            ],
            xaxis: { categories: data.revenue_orders.labels }
        });

        charts.topSellers.updateOptions({
            series: [{ data: data.top_sellers.map(i => i.value) }],
            xaxis: { categories: data.top_sellers.map(i => i.name) }
        });

        charts.status.updateOptions({
            series: data.order_status.values,
            labels: data.order_status.labels
        });

        renderSlowSellers(data.slow_sellers);
    }

    // Filter Navigation Logic
    const filterButtons = document.querySelectorAll('.filter-btn');
    const customPicker = document.querySelector('#custom-date-picker');

    filterButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            // UI Toggle
            filterButtons.forEach(b => {
                b.classList.remove('bg-white', 'shadow-sm', 'text-blue-600');
                b.classList.add('text-slate-600', 'hover:text-slate-900');
            });
            this.classList.remove('text-slate-600', 'hover:text-slate-900');
            this.classList.add('bg-white', 'shadow-sm', 'text-blue-600');
            
            const range = this.dataset.range;
            if (range === 'custom') {
                customPicker.classList.remove('hidden');
            } else {
                customPicker.classList.add('hidden');
                fetchData({ range });
            }
        });
    });

    document.querySelector('#apply-custom-range')?.addEventListener('click', function() {
        const start = document.querySelector('#start-date').value;
        const end = document.querySelector('#end-date').value;
        if (start && end) {
            fetchData({ range: 'custom', start, end });
        }
    });

    // Run initial payload
    fetchData({ range: '7d' });
});
