<?php

namespace App\Repositories;

use App\Models\Testimonial;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;
use Yajra\DataTables\Exceptions\Exception;

class TestimonialRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
    ];

    /**
     * Return searchable fields
     */
    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Testimonial::class;
    }

    /**
     * @return mixed
     */
    public function store($input)
    {
        try {
            DB::beginTransaction();

            $testimonial = Testimonial::create($input);

            if (isset($input['image']) && ! empty($input['image'])) {
                $testimonial->newAddMedia($input['image'])->toMediaCollection(Testimonial::TESTIMONIAL_PATH,
                    config('app.media_disc'));
            }

            DB::commit();

            return $testimonial;
        } catch (Exception $e) {
            DB::rollBack();

            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }

    /**
     * @return Builder|Builder[]|Collection|Model
     */
    public function update($input, $id)
    {
        try {
            DB::beginTransaction();

            $testimonial = Testimonial::findOrFail($id);
            $testimonial->update($input);

            if (isset($input['image']) && ! empty($input['image'])) {
                $testimonial->newClearMediaCollection($input['image'],Testimonial::TESTIMONIAL_PATH);
                $testimonial->newAddMedia($input['image'])->toMediaCollection(Testimonial::TESTIMONIAL_PATH,
                    config('app.media_disc'));
            }

            DB::commit();

            return $testimonial;
        } catch (Exception $e) {
            DB::rollBack();

            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }
}
